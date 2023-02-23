<?php

namespace App\Verification\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Domain\Entity\Type;
use App\Verification\Domain\Aggregate\Code;
use App\Verification\Domain\Aggregate\Subject;
use App\Verification\Domain\Aggregate\UserFingerprint;
use App\Verification\Domain\Aggregate\Verification;
use App\Verification\Domain\Event\VerificationCreatedEvent;
use App\Verification\Domain\Service\VerificationService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateVerificationCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private readonly VerificationService $verificationService,
        private readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function __invoke(CreateVerificationCommand $command)
    {
        $verification = new Verification(
            new Subject($command->getIdentity(), Type::from($command->getType())),
            new Code(random_int(10000000, 99999999)), //fixme use generator
            new UserFingerprint($command->getUserFingerprint())
        );

        $this->verificationService->createVerification($verification);

        $this->eventDispatcher->dispatch(new VerificationCreatedEvent($verification));

    }
}