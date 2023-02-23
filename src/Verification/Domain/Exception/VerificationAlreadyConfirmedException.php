<?php

namespace App\Verification\Domain\Exception;

class VerificationAlreadyConfirmedException extends \DomainException
{
    public static function AlreadyConfirmed(): self
    {
        return new self('Verification already confirmed');
    }
}