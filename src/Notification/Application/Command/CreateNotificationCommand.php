<?php

namespace App\Notification\Application\Command;

class CreateNotificationCommand
{
    public function __construct(
        public readonly string $notificationId,
    )
    {
    }

    public function getCommandName(): string
    {
        return __CLASS__;
    }

    public function getNotificationId(): string
    {
        return $this->notificationId;
    }
}