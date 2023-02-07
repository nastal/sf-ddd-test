<?php


namespace App\Verification\Domain\Entity;

class Code
{
    public function __construct(
        private ?int $code
    ) {
    }

    public function getCode(): ?int
    {
        return $this->code;
    }
}