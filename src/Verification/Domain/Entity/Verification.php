<?php

namespace App\Verification\Domain\Entity;
use App\Shared\Domain\Service\UlidService;

class Verification
{
    private int $id;
    private Subject $subject;
    private Type $type;
    private Code $code;
    private bool $confirmed = false;
    private UserFingerprint $userFingerprint;

    public function __construct(Subject $subject, bool $confirmed = false, Code $code, UserFingerprint $userFingerprint)
    {
        $this->id = UlidService::generate();
        $this->subject = $subject;
        $this->confirmed = $confirmed;
        $this->code = $code;
        $this->userFingerprint = $userFingerprint;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function getType(): Type
    {
        return $this->type;
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

    public function setCofirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;
        return $this;
    }
}