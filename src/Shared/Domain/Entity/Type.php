<?php

namespace App\Shared\Domain\Entity;

enum Type: string
{
    case Email = 'email_confirmation';
    case Mobile = 'mobile_confirmation';
}