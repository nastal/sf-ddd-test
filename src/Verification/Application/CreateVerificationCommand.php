<?php

namespace App\Verification\Application;

use App\Shared\Application\Command\CommandInterface;
use App\Verification\Domain\Entity\Type;

class CreateVerificationCommand implements CommandInterface
{

    public function __construct(
        public readonly string $identity,
        public readonly string $type
    )
    {
    }

    public function getCommandName(): string
    {
        return __CLASS__;
    }


}