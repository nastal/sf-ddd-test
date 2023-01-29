<?php

namespace App\BoundedContexts\Verification\Domain\Verification;

use App\BoundedContexts\Verification\Domain\Verification\VerificationAggregate;

interface VerificationRepositoryInterface
{
    public function store(VerificationAggregate $verification): void;
    public function get(VerificationId $id): VerificationAggregate;
}