<?php

namespace App\Verification\Domain\Service;

use App\Verification\Domain\Aggregate\Verification;
use App\Verification\Domain\Exception\ValidationFailedException;
use App\Verification\Domain\Exception\VerificationAlreadyConfirmedException;
use App\Verification\Domain\Exception\VerificationException;
use App\Verification\Domain\Exception\VerificationExpiredException;
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
            throw new VerificationException('Pending verification exists');
        }

        try {
            $this->verificationRepository->save($verification);
        } catch (\Exception $e) {
            throw new VerificationException('Verification cant be created');
        }

    }

    public function confirm(Verification $verification, int $code): void
    {

        if ($verification->isConfirmed()) {
            throw new VerificationAlreadyConfirmedException('Verification already confirmed');
        }

        $expirationTime = new \DateTimeImmutable('-5 minutes');

        if ($verification->getCreatedAt() <= $expirationTime) {
            throw new VerificationExpiredException('Verification expired');
        }

        if ($verification->getInvalidAttempts() >= $verification->getMaxInvalidAttempts()) {
            throw new ValidationFailedException('No permission to confirm verification');
        }

        if ($verification->getCode()->getCode() !== $code) {
            $this->incrementInvalidAttempts($verification->getUuid());
            throw new ValidationFailedException('Invalid code');
        }

        $verification->setConfirmed();

        $this->verificationRepository->confirm($verification->getUuid());
    }

    private function activePendingVerification(Verification $verification): bool
    {
        $verification = $this->verificationRepository->findPendingIdentity(
            $verification->getSubject()->getIdentity(),
            $verification->getMaxInvalidAttempts()
        );
        return count($verification) > 0;
    }

    private function incrementInvalidAttempts(string $uuid): void
    {
        $this->verificationRepository->incrementInvalidAttempts($uuid);
    }
}