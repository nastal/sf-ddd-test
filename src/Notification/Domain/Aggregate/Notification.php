<?php

namespace App\Notification\Domain\Aggregate;



class Notification
{

    private ?int $id = null;


    private string $recipient;

    private Channel $channel;

    private string $body;

    private bool $dispatched = false;

    public function __construct(string $recipient, Channel $channel, string $body)
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

    public function getChannel(): Channel
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