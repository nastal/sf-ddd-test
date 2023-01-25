<?php

namespace App\MessageHandler;

use App\Message\CheckQueueTestMessage;
use Monolog\Logger;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CheckQueueTestMessageHandler
{
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(CheckQueueTestMessage $message)
    {
        $this->logger->info($message->getName());
    }
}
