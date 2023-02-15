<?php

namespace App\Verification\Infrastructure\EventSubscriber;

use App\Verification\Domain\Event\VerificationCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class VerificationCreatedMessageProducer implements EventSubscriberInterface
{

    public function __construct(
        private MessageBusInterface $messageBus
    )
    {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            VerificationCreatedEvent::class => 'onVerificationCreated',
        ];
    }

    public function onVerificationCreated(VerificationCreatedEvent $event): void
    {
        $this->messageBus->dispatch($event);
    }
}