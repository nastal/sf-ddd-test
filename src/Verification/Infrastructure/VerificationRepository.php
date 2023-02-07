<?php

namespace App\Verification\Infrastructure;

use App\Verification\Domain\Repository\VerificationRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Verification\Domain\Entity\Verification;
use Doctrine\Persistence\ManagerRegistry;

class VerificationRepository extends ServiceEntityRepository implements VerificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Verification::class);
    }

    public function save(Verification $verification): void
    {
        $this->entityManager->persist($verification);
        $this->entityManager->flush();
    }

    public function findBySubjectIdentity(string $identity): ?Verification
    {
        return $this->entityManager->getRepository(Verification::class)->findOneBy([
            'identity' => $identity
        ]);
    }
}