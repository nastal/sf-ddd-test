<?php

namespace App\BoundedContexts\Verification\Domain\Verification;

Enum VerificationTypeEnum
{
    case email_confirmation;
    case mobile_confirmation;
}