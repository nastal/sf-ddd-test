<?php

namespace App\Verification\Domain\Exception;

class VerificationNotFoundException extends \DomainException
{
    public static function NotFound(): self
    {
        return new self('Verification not found');
    }
}