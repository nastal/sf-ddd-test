<?php

namespace App\Verification\Application\Command;

use App\Verification\Domain\Exception\VerificationException;
use App\Verification\Domain\Exception\VerificationNotFoundException;
use App\Verification\Domain\Repository\VerificationRepositoryInterface;
use App\Verification\Domain\Service\VerificationService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ConfirmVerificationHandler
{
    public function __construct(
        private VerificationRepositoryInterface $repository,
        private VerificationService $verificationService
    )
    {
    }

    public function __invoke(ConfirmVerificationCommand $command): int
    {

        $verification = $this->repository->get($command->getVerificationUuid());
        if (!$verification) {
            throw new VerificationNotFoundException('Verification not found');
        }

        $this->verificationService->confirm($verification, $command->getCode());
    }
}
