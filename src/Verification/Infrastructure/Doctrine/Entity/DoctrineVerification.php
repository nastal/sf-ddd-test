<?php

namespace App\Verification\Infrastructure\Doctrine\Entity;

use App\Verification\Infrastructure\Doctrine\Repository\VerificationRepository;
use Container1Oy3axm\getDoctrine_UlidGeneratorService;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: VerificationRepository::class)]
class DoctrineVerification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $uuid;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $identity = null;

    #[ORM\Column]
    private ?bool $confirmed = false;

    #[ORM\Column]
    private ?int $code = null;

    #[ORM\Column]
    private ?string $userFingerprint = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;
        return $this;
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function isConfirmed(): ?bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): self
    {
        $this->confirmed = $confirmed;
        return $this;
    }

    public function getCode(): ?int
    {
        return $this->code;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getUserFingerprint(): ?string
    {
        return $this->userFingerprint;
    }

    public function setUserFingerprint(string $userFingerprint): self
    {
        $this->userFingerprint = $userFingerprint;
        return $this;
    }

}
