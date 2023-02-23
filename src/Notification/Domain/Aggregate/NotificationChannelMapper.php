<?php

namespace App\Notification\Domain\Aggregate;

class NotificationChannelMapper
{

    public const SMS = 'sms-verification';
    public const EMAIL = 'email-verification';

    private const TEMPLATE_MAP = [
        'mobile_confirmation' => ['slug' => self::SMS, 'name' => 'Mobile Confirmation'],
        'email_confirmation' => ['slug' => self::EMAIL, 'name' => 'Email Confirmation'],
    ];

    public function mapSlugToTemplate(string $slug): Channel
    {
        if (!array_key_exists($slug, self::TEMPLATE_MAP)) {
            throw new \InvalidArgumentException(sprintf('Unknown slug: %s', $slug));
        }

        $templateData = self::TEMPLATE_MAP[$slug];

        return new Channel($templateData['slug']);
    }
}