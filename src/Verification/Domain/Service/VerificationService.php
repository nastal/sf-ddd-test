<?php

namespace App\Verification\Domain\Service;

use App\Verification\Domain\Aggregate\Verification;
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
        try {
            $this->verificationRepository->save($verification);
        } catch (\Exception $e) {
            throw new \Exception('Verification already exists');
        }

    }
}