<?php

namespace App\Notification\Domain\Service;

use App\Notification\Domain\Aggregate\Notification;
use App\Notification\Domain\Repository\NotificationRepositoryInterface;

class NotificationService
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {
    }

    public function createNotification(Notification $notification): int
    {
        return $this->notificationRepository->save($notification);
    }

    public function getNotification(int $id): Notification
    {
        return $this->notificationRepository->getNotification($id);
    }

    public function dispatch(Notification $notification): void
    {
        $this->notificationRepository->dispatch($notification);
    }
}
