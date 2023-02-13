<?php

namespace App\Verification\UI\HTTP;

use App\Verification\Application\CreateVerificationCommand;
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

        $this->messageBus->dispatch($command);

        return $this->json([
            'identity' => $content['identity'],
            'type' => $content['type'],
            'ip' => $request->getClientIp(),
            'userAgent' => $request->headers->get('User-Agent'),
        ]);
    }
}
