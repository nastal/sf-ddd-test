<?php

namespace App\Verification\Domain\Event;


use Symfony\Contracts\EventDispatcher\Event;

class VerificationCreatedEvent extends Event
{
    protected \DateTimeImmutable $occur;
    public function __construct(private readonly string $verificationUuid)
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getVerificationUuid(): string
    {
        return $this->verificationUuid;
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }
}
