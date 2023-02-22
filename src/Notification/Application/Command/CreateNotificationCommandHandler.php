<?php

namespace App\Notification\Application\Command;

use App\Notification\Domain\Aggregate\Notification;
use App\Notification\Domain\Aggregate\NotificationChannelMapper;
use App\Notification\Domain\Service\NotificationService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;


#[AsMessageHandler]
class CreateNotificationCommandHandler
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger,
        private readonly NotificationChannelMapper $notificationChannelMapper
    )
    {
    }

    public function __invoke(CreateNotificationCommand $command): void
    {

        $this->logger->info('HANDLER INVOKED');

        $NotificationChannel = $this->notificationChannelMapper
            ->mapSlugToTemplate($command->getSlug());

        $body = [
            'slug' => $NotificationChannel->getName(),
            'variables' => ['code' => $command->getCode()],
        ];

        $template = $this->requestTemplate($body);

        //persist notification
        $notification = new Notification(
            $command->getIdentity(),
            $NotificationChannel,
            $template
        );

        $this->notificationService->createNotification($notification);
        //send notification

    }

    private function requestTemplate(array $body): string
    {
        $response = $this->client->request(
            'POST',
            'http://webserver/templates/render', //fixme move to env
            [
                'json' => $body,
            ]
        );

        return $response->getContent();
    }
}