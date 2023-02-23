<?php

namespace App\Verification\Domain\Exception;

class ValidationFailedException extends \DomainException
{
    public static function create(string $message): self
    {
        return new self($message);
    }
}