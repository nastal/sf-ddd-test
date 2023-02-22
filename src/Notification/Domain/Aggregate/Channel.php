<?php

namespace App\Notification\Domain\Aggregate;

use App\Shared\Domain\Entity\Type;

class Channel
{

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
}
