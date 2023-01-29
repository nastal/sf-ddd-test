<?php

namespace App\BoundedContexts\Verification\Domain\Verification;

class VerificationService
{
    private VerificationRepositoryInterface $repository;

    public function __construct(VerificationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(VerificationAggregate $verification): VerificationAggregate
    {
        $this->repository->store($verification);
        //VerificationCreatedDomainEvent::dispatch($verification);

        return $verification;
    }

    public function confirm(VerificationId $id, string $code): void
    {
        $verification = $this->repository->get($id);

        //VerificationConfirmedDomainEvent::dispatch($verification);

        //VerificationConfirmationFailedDomainEvent::dispatch($verification);

        //todo add verification code check
    }
}