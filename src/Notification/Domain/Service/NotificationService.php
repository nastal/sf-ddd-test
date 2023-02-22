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

    public function createNotification(Notification $notification): void
    {
        $this->notificationRepository->save($notification);
    }
}
