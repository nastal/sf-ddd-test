<?php

namespace App\Verification\Domain\Entity;
use App\Shared\Domain\Service\UlidService;
use Ramsey\Uuid\Uuid;

class Verification
{
    private string $uuid;
    private Subject $subject;
    private Code $code;
    private bool $confirmed = false;
    private UserFingerprint $userFingerprint;

    public function __construct(Subject $subject, bool $confirmed = false, Code $code, UserFingerprint $userFingerprint)
    {
        $this->uuid = UlidService::generate();
        $this->subject = $subject;
        $this->confirmed = $confirmed;
        $this->code = $code;
        $this->userFingerprint = $userFingerprint;
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

    public function getUserFingerprint(): UserFingerprint
    {
        return $this->userFingerprint;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}