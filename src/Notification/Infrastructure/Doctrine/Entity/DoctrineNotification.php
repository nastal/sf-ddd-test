<?php

namespace App\Notification\Infrastructure\Doctrine\Entity;


use App\Notification\Infrastructure\Doctrine\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[ORM\Table(name: 'notifications')]
class DoctrineNotification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $recipient;

    #[ORM\Column(length: 255)]
    private string $channel;

    #[ORM\Column(type: 'text')]
    private string $body;

    #[ORM\Column(type: 'boolean')]
    private bool $dispatched = false;

    public function __construct(string $recipient, string $channel, string $body)
    {
        $this->recipient = $recipient;
        $this->channel = $channel;
        $this->body = $body;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function isDispatched(): bool
    {
        return $this->dispatched;
    }

    public function setDispatched(bool $dispatched): void
    {
        $this->dispatched = $dispatched;
    }
}