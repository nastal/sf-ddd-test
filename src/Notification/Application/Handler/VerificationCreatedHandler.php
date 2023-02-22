<?php

namespace App\Notification\Application\Handler;

use App\Notification\Application\Command\CreateNotificationCommand;
use App\Verification\Domain\Event\VerificationCreatedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
readonly class VerificationCreatedHandler
{

    public function __construct(private readonly MessageBusInterface $messageBus
    )
    {
    }

    public function __invoke(VerificationCreatedEvent $event): void
    {
        $this->messageBus->dispatch(new CreateNotificationCommand(
            $event->getCode(),
            $event->getIdentity(),
            $event->getType()
        ));
    }
}