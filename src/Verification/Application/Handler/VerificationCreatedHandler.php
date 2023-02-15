<?php

namespace App\Verification\Application\Handler;

use App\Verification\Domain\Event\VerificationCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class VerificationCreatedHandler
{

    public function __construct(private LoggerInterface $logger)
    {
    }


    public function __invoke(VerificationCreatedEvent $event): void
    {
        //fixme remove
        $this->logger->log('info', 'verification event handled');
    }
}