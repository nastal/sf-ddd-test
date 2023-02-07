<?php

namespace App\Verification\Domain\Entity;

enum Type: string
{
    case Email = 'email_confirmation';
    case Mobile = 'mobile_confirmation';
}