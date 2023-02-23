<?php

namespace App\Notification\Application\Command;

use App\Notification\Domain\Aggregate\Notification;
use App\Notification\Domain\Aggregate\NotificationChannelMapper;
use App\Notification\Domain\Service\NotificationService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\HttpClientInterface;

#[AsMessageHandler]
class DispatchNotificationCommandHandler
{

    private string $gotifyXtoken;
    private string $gotifyHost;
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly LoggerInterface $logger,
        private readonly MailerInterface $mailer, // added dependency for Swift Mailer
        private readonly HttpClientInterface $httpClient, // added dependency for HTTP client
        $gotifyXtoken,
        $gotifyHost
    )
    {
        $this->gotifyXtoken = $gotifyXtoken;
        $this->gotifyHost = $gotifyHost;
    }

    public function __invoke(DispatchNotificationCommand $command): void
    {

        $notification = $this->notificationService->getNotification($command->getId());

        if (!$notification) {
            $this->logger->error("Notification not found for id: {$command->getId()}");
            return;
        }

        // Dispatch notification through the appropriate channel
        //fixme move this to a strategy
        switch ($command->getChannel()->getName()) {
            case NotificationChannelMapper::EMAIL:
                $this->sendEmail($notification, $command->getCode());
                break;

            case NotificationChannelMapper::SMS:
                $this->sendSms($notification);
                break;

            default:
                $this->logger->error("Invalid channel for notification id: {$command->getId()}");
                break;
        }

        // Mark notification as dispatched
        $notification->setDispatched(true);
        $this->notificationService->dispatch($notification);
    }

    private function sendEmail(Notification $notification, $code): void
    {
        $template = $notification->getBody();

        $this->logger->info("Sending email to {$notification->getRecipient()} with template: {$template}");

        $email = (new Email())
            ->from('no-reply@example.com')
            ->to($notification->getRecipient())
            ->subject('Notification code')
            ->text('Your verification code is: ' . $code)
            ->html($notification->getBody());

        $this->mailer->send($email);

    }

    private function sendSms(Notification $notification): void
    {
        $template = $notification->getBody();

        $this->logger->info("Sending SMS to {$notification->getRecipient()} with template: {$template}");
        $response = $this->httpClient->request(
            'POST',
            $this->gotifyHost,
            [
                'json' => [
                    'extras' => [
                        'recipient' => $notification->getRecipient()
                    ],
                    'recipient' => $notification->getRecipient(),
                    'message' => $notification->getBody()
                ],
                'headers' => [
                    'X-Gotify-Key' => $this->gotifyXtoken,
                ]
            ]
        );

        if ($response->getStatusCode() === 200) {
            $this->logger->info("SMS sent for notification id: {$notification->getId()}");
        } else {
            $this->logger->error("Failed to send SMS for notification id: {$notification->getId()}");
            throw new \Exception("Failed to send SMS for notification id: {$notification->getId()}");
        }
    }
}