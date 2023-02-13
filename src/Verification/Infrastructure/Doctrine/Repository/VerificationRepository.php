<?php

namespace App\Verification\Infrastructure\Doctrine\Repository;

use App\Verification\Domain\Repository\VerificationRepositoryInterface;
use App\Verification\Domain\Entity\Verification;
use App\Verification\Infrastructure\Doctrine\Entity\DoctrineVerification;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository
 *
 * @method DoctrineVerification|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctrineVerification|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctrineVerification[]    findAll()
 * @method DoctrineVerification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerificationRepository extends ServiceEntityRepository implements VerificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineVerification::class);
    }

    public function save(Verification $entity): void
    {
        $doctrineVerification = new DoctrineVerification();
        $doctrineVerification->setType($entity->getType()->value);
        $doctrineVerification->setCode($entity->getCode()->getCode());
        $doctrineVerification->setUserFingerprint($entity->getUserFingerprint()->getUserFingerprint());
        $doctrineVerification->setIdentity($entity->getIdentity());
        $doctrineVerification->setConfirmed($entity->isConfirmed());
        $doctrineVerification->setUuid($entity->getUuid());


        $this->getEntityManager()->persist($doctrineVerification);
        $this->getEntityManager()->flush();

    }

    public function findBySubjectIdentity(string $identity): ?\App\Verification\Domain\Entity\Verification
    {
        return $this->entityManager->getRepository(DoctrineVerification::class)->findOneBy([
            'identity' => $identity
        ]);
    }
}
