<?php

namespace App\Notification\Domain\Aggregate;

class NotificationChannelMapper
{
    private const TEMPLATE_MAP = [
        'mobile_confirmation' => ['slug' => 'sms-verification', 'name' => 'Mobile Confirmation'],
        'email_confirmation' => ['slug' => 'email-verification', 'name' => 'Email Confirmation'],
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