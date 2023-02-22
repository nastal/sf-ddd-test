<?php

namespace App\Notification\Infrastructure\Doctrine\Repository;

use App\Notification\Domain\Aggregate\Notification;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;
use App\Notification\Infrastructure\Doctrine\Entity\DoctrineNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NotificationRepository extends ServiceEntityRepository implements NotificationRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineNotification::class);
    }

    public function save(Notification $notification): void
    {
        $doctrineNotification = new DoctrineNotification(
            $notification->getid(),
            $notification->getChannel()->getName(),
            $notification->getBody(),
        );
        $this->_em->persist($doctrineNotification);
        $this->_em->flush();
    }

    public function dispatch(Notification $notification): void
    {
        $notification->setDispatched(true);
        $this->_em->flush();
    }
}