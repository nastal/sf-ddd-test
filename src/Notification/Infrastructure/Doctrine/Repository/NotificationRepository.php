<?php

namespace App\Notification\Infrastructure\Doctrine\Repository;

use App\Notification\Domain\Aggregate\Channel;
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

    public function save(Notification $notification): int
    {
        $doctrineNotification = new DoctrineNotification(
            $notification->getRecipient(),
            $notification->getChannel()->getName(),
            $notification->getBody(),
        );
        $this->_em->persist($doctrineNotification);
        $this->_em->flush();
        return $doctrineNotification->getId();
    }

    public function getNotification(int $id): Notification
    {
        $doctrineNotification = $this->find($id);
        $notification = new Notification(
            $doctrineNotification->getRecipient(),
            new Channel($doctrineNotification->getChannel()),
            $doctrineNotification->getBody(),
        );
        $notification->setId($doctrineNotification->getId());
        return $notification;
    }

    public function dispatch(Notification $notification): void
    {
        $doctrineNotification = $this->find($notification->getId());
        $doctrineNotification->setDispatched($notification->isDispatched());
        $this->_em->flush();
    }
}