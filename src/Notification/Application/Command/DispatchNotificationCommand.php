<?php

namespace App\Notification\Application\Command;

use App\Notification\Domain\Aggregate\Channel;

class DispatchNotificationCommand
{
    public function __construct(
        public readonly int $id,
        public readonly Channel $channel,
        public readonly string $code
    )
    {
    }

    public function getCommandName(): string
    {
        return __CLASS__;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getChannel(): Channel
    {
        return $this->channel;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}