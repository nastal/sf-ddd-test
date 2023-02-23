<?php

namespace App\Verification\UI\HTTP;

use App\Verification\Application\Command\ConfirmVerificationCommand;
use App\Verification\Application\Command\CreateVerificationCommand;
use App\Verification\Domain\Exception\ValidationFailedException;
use App\Verification\Domain\Exception\VerificationAlreadyConfirmedException;
use App\Verification\Domain\Exception\VerificationExpiredException;
use App\Verification\Domain\Exception\VerificationNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class VerificationController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private ValidatorInterface $validator
    )
    {
    }

    #[Route('/verification', name: 'verification', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        //todo validate request
        $content = json_decode($request->getContent(), true)['subject'];
        $command = new CreateVerificationCommand(
            $content['identity'],
            $content['type'],
            $request->headers->get('User-Agent'),
            $request->getClientIp()
        );

        try {
            $this->messageBus->dispatch($command); //sync
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 409);
        }

        return $this->json([
            'identity' => $content['identity'],
            'type' => $content['type'],
            'ip' => $request->getClientIp(),
            'userAgent' => $request->headers->get('User-Agent'),
        ], 201);
    }

    #[Route('/verification/{id}/confirm', name: 'confirm_verification', methods: ['PUT'])]
    public function confirm(Request $request, string $id): JsonResponse
    {
        // validate request
        $validationResult = $this->validator->validate(
            $request->getContent(),
            new Assert\Json(['message' => 'Malformed JSON passed.'])
        );

        if (count($validationResult) > 0) {
            return $this->json(['message' => $validationResult->get(0)->getMessage()], 400);
        }

        $requestData = json_decode($request->getContent(), true);
        $code = $requestData['code'];

        $command = new ConfirmVerificationCommand($id, $code);

        try {
            $this->messageBus->dispatch($command); //sync
        } catch (HandlerFailedException $e) {
            $exception = $e->getPrevious();

            if ($exception instanceof VerificationNotFoundException) {
                return $this->json(['message' => $exception->getMessage()], 404);
            }

            if ($exception instanceof VerificationAlreadyConfirmedException) {
                return $this->json(['message' => $exception->getMessage()], 409);
            }

            if ($exception instanceof VerificationExpiredException) {
                return $this->json(['message' => $exception->getMessage()], 410);
            }

            if ($exception instanceof ValidationFailedException) {
                return $this->json(['message' => $exception->getMessage()], 422);
            }

            return $this->json(['message' => $exception->getMessage()], 500);
        }

        return $this->json(['message' => 'Verification confirmed'], 204);

    }
}
