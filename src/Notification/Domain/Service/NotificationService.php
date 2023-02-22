<?php

namespace App\Notification\Domain\Service;

class NotificationService
{
    public function __construct(
        private NotificationRepositoryInterface $notificationRepository
    ) {
    }

    public function createNotification(CreateNotificationCommand $command): void
    {
        //todo invariants
        $notification = new Notification($command->getNotificationId());
        $this->notificationRepository->save($notification);
    }
}
