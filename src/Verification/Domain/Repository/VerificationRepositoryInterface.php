<?php

namespace App\Verification\Domain\Repository;

use App\Verification\Domain\Entity\Verification;

interface VerificationRepositoryInterface
{
    public function save(Verification $verification): void;
    public function findBySubjectIdentity(string $identity): ?Verification;
}