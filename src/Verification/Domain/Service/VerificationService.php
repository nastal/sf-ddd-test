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

        //It must not be possible to create a duplicated "pending" verification for the same subject.
        if($this->activePendingVerification($verification)) {
            throw new \DomainException('Pending verification exists');
        }

        try {
            $this->verificationRepository->save($verification);
        } catch (\Exception $e) {
            throw new \Exception('Verification cant be created');
        }

    }

    public function activePendingVerification(Verification $verification): bool
    {
        $verification = $this->verificationRepository->findPendingIdentity($verification->getSubject()->getIdentity());
        return count($verification) > 0;
    }
}