<?php

namespace App\Notification\Domain\Repository;

use App\Notification\Domain\Aggregate\Notification;

interface NotificationRepositoryInterface
{
    public function save(Notification $notification): int;

    public function getNotification(int $id): Notification;

    public function dispatch(Notification $notification): void;
}