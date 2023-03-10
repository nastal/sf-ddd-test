<?php

namespace App\Verification\Infrastructure\Doctrine\Repository;

use App\Shared\Domain\Entity\Type;
use App\Verification\Domain\Aggregate\Code;
use App\Verification\Domain\Aggregate\Subject;
use App\Verification\Domain\Aggregate\UserFingerprint;
use App\Verification\Domain\Repository\VerificationRepositoryInterface;
use App\Verification\Domain\Aggregate\Verification;
use App\Verification\Infrastructure\Doctrine\Entity\DoctrineVerification;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository
 *
 * @method DoctrineVerification|null find($id, $lockMode = null, $lockVersion = null)
 * @method DoctrineVerification|null findOneBy(array $criteria, array $orderBy = null)
 * @method DoctrineVerification[]    findAll(array $criteria, array $orderBy = null)
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
        $doctrineVerification->setUserFingerprint($entity->getUserFingerprint()->getUserAgent());
        $doctrineVerification->setIdentity($entity->getIdentity());
        $doctrineVerification->setConfirmed($entity->isConfirmed());
        $doctrineVerification->setUuid($entity->getUuid());
        $doctrineVerification->setCreatedAt($entity->getCreatedAt());
        $doctrineVerification->setIp($entity->getUserFingerprint()->getIp());
        $doctrineVerification->setCreatedAt($entity->getCreatedAt());

        $this->getEntityManager()->persist($doctrineVerification);
        $this->getEntityManager()->flush();

    }

    public function findPendingIdentity(string $identity, int $maxInvalidAttempts): ?array
    {
        $expirationTime = new \DateTimeImmutable('-5 minutes');

        $qb = $this->createQueryBuilder('v')
            ->where('v.identity = :identity')
            ->andWhere('v.confirmed = false')
            ->andWhere('v.invalidAttempts < :maxInvalidAttempts')
            ->andWhere('v.createdAt >= :expirationTime')
            ->setParameter('identity', $identity)
            ->setParameter('maxInvalidAttempts', $maxInvalidAttempts)
            ->setParameter('expirationTime', $expirationTime);

        return $qb->getQuery()->getResult() ?? [];
    }

    public function get(string $uuid): ?Verification
    {
        $doctrineVerification = $this->findOneBy(['uuid' => $uuid]);
        if(!$doctrineVerification) {
            return null;
        }

        $verification = new Verification(
            new Subject(
                $doctrineVerification->getIdentity(),
                Type::from($doctrineVerification->getType())
            ),
            new Code($doctrineVerification->getCode()),
            new UserFingerprint(
                $doctrineVerification->getUserFingerprint(),
                $doctrineVerification->getIp()
            ),
            $doctrineVerification->isConfirmed()
        );

        $verification->setUuid($doctrineVerification->getUuid());
        $verification->setCreatedAt($doctrineVerification->getCreatedAt());
        $verification->setInvalidAttempts($doctrineVerification->getInvalidAttempts());

        return $verification;
    }

    public function confirm(string $uuid): void
    {
        $doctrineVerification = $this->findOneBy(['uuid' => $uuid]);
        if ($doctrineVerification) {
            $doctrineVerification->setConfirmed(true);
            $this->getEntityManager()->flush();
        }
    }

    public function incrementInvalidAttempts(string $uuid): void
    {
        $doctrineVerification = $this->findOneBy(['uuid' => $uuid]);
        if ($doctrineVerification) {
            $doctrineVerification->setInvalidAttempts($doctrineVerification->getInvalidAttempts() + 1);
            $this->getEntityManager()->flush();
        }
    }
}
