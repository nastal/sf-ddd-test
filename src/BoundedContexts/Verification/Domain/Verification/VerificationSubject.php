<?php

namespace App\BoundedContexts\Verification\Domain\Verification;

class VerificationSubject
{
    private VerificationTypeEnum $type;
    private string $identity;

    public function __construct(VerificationTypeEnum $type, string $identity)
    {
        $this->type = $type;
        $this->identity = $identity;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getIdentity()
    {
        return $this->identity;
    }
}