<?php

namespace App\Verification\Application\Command;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Command\CommandInterface;
use App\Shared\Domain\Entity\Type;
use App\Verification\Domain\Entity\Code;
use App\Verification\Domain\Entity\Subject;
use App\Verification\Domain\Entity\UserFingerprint;
use App\Verification\Domain\Entity\Verification;
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

    public function __invoke(CommandInterface $command)
    {
        $verification = new Verification(
            new Subject($command->getIdentity(), Type::from($command->getType())),
            new Code(random_int(1000000, 9999999)),
            new UserFingerprint($command->getUserFingerprint())
        );

        $this->verificationService->createVerification($verification);

        //fixme last id
        $this->eventDispatcher->dispatch(new VerificationCreatedEvent('last_created_uuid'));

    }
}