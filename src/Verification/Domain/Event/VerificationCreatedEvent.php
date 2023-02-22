<?php

namespace App\Verification\Domain\Event;


use App\Verification\Domain\Aggregate\Verification;
use Symfony\Contracts\EventDispatcher\Event;

class VerificationCreatedEvent extends Event
{
    protected \DateTimeImmutable $occur;

    public function __construct(private readonly Verification $verification)
    {
        $this->occur = new \DateTimeImmutable();
    }

    public function getVerificationId(): string
    {
        return $this->verification->getUuid();
    }

    public function getCode(): int
    {
        return $this->verification->getCode()->getCode();
    }

    public function getIdentity(): string
    {
        return $this->verification->getIdentity();
    }

    public function getType(): string
    {
        return $this->verification->getType()->value;
    }

    public function getOccur(): \DateTimeImmutable
    {
        return $this->occur;
    }
}
