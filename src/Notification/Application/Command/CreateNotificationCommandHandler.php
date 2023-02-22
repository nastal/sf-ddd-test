<?php

namespace App\Notification\Application\Command;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;


#[AsMessageHandler]
class CreateNotificationCommandHandler
{
    public function __construct(
        //private readonly NotificationService $notificationService,
        private readonly HttpClientInterface $client,
        private readonly LoggerInterface $logger
    )
    {
    }

    public function __invoke(CreateNotificationCommand $command): void
    {

        $this->logger->info(__CLASS__ . ' triggered');
        /*$response = $this->client->request('POST', 'docker.for.mac.localhost:64000', [
            'body' => json_encode(
                ['slug' => 'sms-verification',
                'variables' => [
                    'code' => '123456'
                ]]),
        ]);*/

        $this->logger->info($command->getNotificationId());

    }

    private function renderTemplate(): string
    {
        return 'rendered template';
    }
}