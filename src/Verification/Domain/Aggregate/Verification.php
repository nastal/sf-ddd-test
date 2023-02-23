<?php

namespace App\Verification\Domain\Aggregate;

use App\Shared\Domain\Entity\Type;
use App\Shared\Domain\Service\UlidService;
use DateTimeZone;

class Verification
{
    private string $uuid;
    private Subject $subject;
    private Code $code;
    private bool $confirmed = false;
    private UserFingerprint $userFingerprint;

    //created at property
    private \DateTimeImmutable $createdAt;

    private int $invalidAttempts = 0;

    private int $maxInvalidAttempts = 5;

    public function __construct(Subject $subject, Code $code, UserFingerprint $userFingerprint, bool $confirmed = false)
    {
        $this->uuid = UlidService::generate();
        $this->subject = $subject;
        $this->confirmed = $confirmed;
        $this->code = $code;
        $this->userFingerprint = $userFingerprint;
        $this->createdAt = new \DateTimeImmutable('now', new DateTimeZone('UTC'));
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getIdentity(): string
    {
        return $this->subject->getIdentity();
    }

    public function getType(): Type
    {
        return $this->getSubject()->getType();
    }

    public function getCode(): Code
    {
        return $this->code;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed = true): void
    {
        $this->confirmed = $confirmed;
    }

    public function getUserFingerprint(): UserFingerprint
    {
        return $this->userFingerprint;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getInvalidAttempts(): int
    {
        return $this->invalidAttempts;
    }

    public function setInvalidAttempts(int $invalidAttempts): self
    {
        $this->invalidAttempts = $invalidAttempts;
        return $this;
    }

    public function getMaxInvalidAttempts(): int
    {
        return $this->maxInvalidAttempts;
    }
}