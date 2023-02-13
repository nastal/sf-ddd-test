<?php

namespace App\Verification\Domain\Service;

use App\Verification\Domain\Entity\Verification;
use App\Verification\Domain\Repository\VerificationRepositoryInterface;

class VerificationService
{
    public function __construct(
        private VerificationRepositoryInterface $verificationRepository
    ) {
    }

    public function createVerification(Verification $verification): void
    {
        //todo invariants
        $this->verificationRepository->save($verification);
    }
}