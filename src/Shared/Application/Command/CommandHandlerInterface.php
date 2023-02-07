<?php

namespace App\Shared\Application\Command;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}