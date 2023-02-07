<?php

namespace App\Verification\Application;

use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\Command\CommandInterface;

class CreateVerificationCommandHandler implements CommandHandlerInterface
{

    public function __construct(
        private readonly ConfirmationService $confirmationService
    )
    {
    }
    public function handle(CommandInterface $command): void
    {
        //todo: implement
    }
}