<?php

namespace App\Shared\Application\Command;

interface CommandInterface
{
    public function getCommandName(): string;
}