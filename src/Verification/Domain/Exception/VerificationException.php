<?php

namespace App\Verification\Domain\Exception;

class VerificationException extends \DomainException
{
    public static function AlreadyExists(): self
    {
        return new self('Verification already exists');
    }
}