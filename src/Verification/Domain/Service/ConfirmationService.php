<?php

namespace App\Verification\Domain\Service;

use App\Verification\Domain\Entity\Code;
use App\Verification\Domain\Entity\Type;
use App\Verification\Domain\Entity\UserFingerprint;
use App\Verification\Domain\Repository\VerificationRepositoryInterface;

class ConfirmationService
{
    public function __construct(
        private VerificationRepositoryInterface $verificationRepository
    ) {
    }

    public function createVerification(string $identity, Type $type, UserFingerprint $userFingerprint): void
    {
        $code = new Code();
        $this->verificationRepository->create($identity, $type, $code, $userFingerprint);
    }
}