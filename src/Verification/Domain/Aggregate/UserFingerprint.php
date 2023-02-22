<?php

namespace App\Verification\Domain\Aggregate;

class UserFingerprint
{
    public function __construct(
        private ?string $userFingerprint
    ) {
    }

    public function getUserFingerprint(): ?string
    {
        return $this->userFingerprint;
    }
}