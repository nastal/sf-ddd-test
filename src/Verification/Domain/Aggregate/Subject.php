<?php

namespace App\Verification\Domain\Entity;

use App\Shared\Domain\Entity\Type;

class Subject
{
    private ?int $id = null;
    private ?string $identity;
    private Type $type;

    public function __construct(string $identity, Type $type)
    {
        $this->identity = $identity;
        $this->type = $type;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

}