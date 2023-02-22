<?php

namespace App\Notification\Application\Command;

class CreateNotificationCommand
{
    public function __construct(
        public readonly string $code,
        public readonly string $identity,
        public readonly string $slug,
    )
    {
    }

    public function getCommandName(): string
    {
        return __CLASS__;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }
}