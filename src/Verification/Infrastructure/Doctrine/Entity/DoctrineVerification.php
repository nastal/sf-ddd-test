<?php

namespace App\Verification\Infrastructure\Doctrine\Entity;

use App\Verification\Infrastructure\Doctrine\Repository\VerificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity(repositoryClass: VerificationRepository::class)]
#[ORM\Table(name: 'verification')]
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

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $invalidAttempts = 0;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getInvalidAttempts(): ?int
    {
        return $this->invalidAttempts;
    }

    public function setInvalidAttempts(int $invalidAttempts): self
    {
        $this->invalidAttempts = $invalidAttempts;
        return $this;
    }

}
