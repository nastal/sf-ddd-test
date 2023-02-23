<?php

namespace App\Verification\Application\Command;

class ConfirmVerificationCommand
{
    public function __construct(
        private string $verificationUuid,
        private string $code
    )
    {
    }

    public function getVerificationUuid(): string
    {
        return $this->verificationUuid;
    }

    public function getCode(): string
    {
        return $this->code;
    }

}
