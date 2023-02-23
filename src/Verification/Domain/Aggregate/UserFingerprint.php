<?php

namespace App\Verification\Domain\Aggregate;

class UserFingerprint
{
    public function __construct(
        private ?string $userAgent,
        private ?string $ip,
    ) {
    }

    public function getUserAgent(): ?string
    {
        return $this->userAgent;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }
}