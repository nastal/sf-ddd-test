<?php

namespace App\Notification\Application\Command;

use App\Notification\Domain\Aggregate\Notification;
use App\Notification\Domain\Service\NotificationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class DispatchNotificationCommandHandler
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly LoggerInterface $logger,
        //private readonly MailerInterface $mailer, // added dependency for Swift Mailer
        private readonly HttpClientInterface $httpClient // added dependency for HTTP client
    )
    {
    }

    public function __invoke(DispatchNotificationCommand $command): void
    {


        $notification = $this->notificationService->getNotification($command->getId());

        $this->logger->info('Dispatching notification', [
            'id' => $command->getId(),
            'channel' => $command->getChannel()->getName(),
            'notification' => $notification->getId(),
        ]);

        if (!$notification) {
            $this->logger->error("Notification not found for id: {$command->getId()}");

            return;
        }

        $recipient = $notification->getRecipient();

        // Dispatch notification through the appropriate channel
        //fixme move this to a strategy
        /*switch ($command->getChannel()->getName()) {
            case NotificationChannelMapper::EMAIL:
                $this->sendEmail($notification, $recipient);
                break;

            case NotificationChannelMapper::SMS:
                $this->sendSms($notification, $recipient);
                break;

            default:
                $this->logger->error("Invalid channel for notification id: {$command->getId()}");
                break;
        }*/

        // Mark notification as dispatched
        $notification->setDispatched(true);
        $this->notificationService->dispatch($notification);
    }

    private function sendEmail(Notification $notification, string $recipient): void
    {
        $template = $notification->getBody();

        $this->logger->info("Sending email to {$recipient} with template: {$template}");

        /*$message = (new \Swift_Message($subject))
            ->setFrom('no-reply@example.com')
            ->setTo($recipient)
            ->setBody($body);

        try {
            $this->mailer->send($message);
            $this->logger->info("Email sent for notification id: {$notification->getId()}");
        } catch (\Exception $e) {
            $this->logger->error("Failed to send email for notification id: {$notification->getId()} - {$e->getMessage()}");
        }*/
    }

    private function sendSms(Notification $notification, string $recipient): void
    {
        $template = $notification->getBody();

        $this->logger->info("Sending SMS to {$recipient} with template: {$template}");
        /*$response = $this->httpClient->request(
            'POST',
            'http://gotify/server/send-sms', // fixme move to env
            [
                'json' => [
                    'recipient' => $recipient,
                    'message' => $body
                ]
            ]
        );

        if ($response->getStatusCode() === 200) {
            $this->logger->info("SMS sent for notification id: {$notification->getId()}");
        } else {
            $this->logger->error("Failed to send SMS for notification id: {$notification->getId()}");
        }*/
    }
}