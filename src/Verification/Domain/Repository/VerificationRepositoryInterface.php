<?php

namespace App\Verification\Domain\Repository;

use App\Verification\Domain\Aggregate\Verification;

interface VerificationRepositoryInterface
{
    public function save(Verification $verification): void;
    public function findPendingIdentity(string $identity, int $maxInvalidAttempts): ?array;

    public function get(string $uuid): ?Verification;

    public function confirm(string $uuid): void;

    public function incrementInvalidAttempts(string $uuid): void;
}