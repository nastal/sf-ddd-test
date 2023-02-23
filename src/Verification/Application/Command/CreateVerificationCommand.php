<?php

namespace App\Verification\Application\Command;

use App\Shared\Application\Command\CommandInterface;

class CreateVerificationCommand implements CommandInterface
{

    public function __construct(
        public readonly string $identity,
        public readonly string $type,
        public readonly string $userAgent,
        public readonly string $ip,
    )
    {
    }

    public function getCommandName(): string
    {
        return __CLASS__;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getUserAgent(): string
    {
        return $this->userAgent;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

}