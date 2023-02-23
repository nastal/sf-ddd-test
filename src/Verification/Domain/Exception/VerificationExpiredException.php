<?php

namespace App\Verification\Domain\Exception;

class VerificationExpiredException extends \DomainException
{
    public static function NotFound(): self
    {
        return new self('Verification expired');
    }
}