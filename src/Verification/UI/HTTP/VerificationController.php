<?php

namespace App\Verification\UI\HTTP;

use App\Verification\Application\Command\CreateVerificationCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class VerificationController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
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
            $request->headers->get('User-Agent')
        );

        try {
            $this->messageBus->dispatch($command); //sync
        } catch (\Exception $e) {
            return $this->json(['message' => $e->getMessage()], 400);
        }

        return $this->json([
            'identity' => $content['identity'],
            'type' => $content['type'],
            'ip' => $request->getClientIp(),
            'userAgent' => $request->headers->get('User-Agent'),
        ], 201);
    }
}
