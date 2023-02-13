<?php

namespace App\Verification\Application;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Verification\Domain\Entity\Code;
use App\Verification\Domain\Entity\Subject;
use App\Verification\Domain\Entity\Type;
use App\Verification\Domain\Entity\UserFingerprint;
use App\Verification\Domain\Entity\Verification;
use App\Verification\Domain\Service\VerificationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateVerificationCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly VerificationService $verificationService,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function __invoke(CommandInterface $command)
    {
        $verification = new Verification(
            new Subject($command->getIdentity(), Type::from($command->getType())),
            false,
            new Code(random_int(1000000, 9999999)),
            new UserFingerprint($command->getUserFingerprint())
        );

        $this->verificationService->createVerification($verification, true);
    }
}