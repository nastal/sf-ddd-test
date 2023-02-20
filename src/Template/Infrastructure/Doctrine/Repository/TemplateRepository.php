<?php

namespace App\Template\Infrastructure\Doctrine\Repository;

use App\Template\Domain\Model\TemplateRepositoryInterface;
use App\Template\Infrastructure\Doctrine\Entity\DoctrineTemplate;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository
 *
*/
class TemplateRepository extends ServiceEntityRepository implements TemplateRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineTemplate::class);
    }

    public function findBySlug(string $slug): ?DoctrineTemplate
    {
        return $this->findOneBy(['slug' => $slug]);
    }
}
