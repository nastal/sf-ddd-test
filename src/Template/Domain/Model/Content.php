<?php

namespace App\Template\Domain\Model;

class Content
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function renderCode(string $code): string
    {
        return str_replace('{{ code }}', $code, $this->value);
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}