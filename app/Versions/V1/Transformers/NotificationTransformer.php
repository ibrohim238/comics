<?php

namespace App\Versions\V1\Transformers;

use App\Dto\NotificationDto;
use App\Notifications\ChapterCreated;
use Illuminate\Notifications\DatabaseNotification;

class NotificationTransformer
{
    /**
     * @throws \Exception
     */
    public function transform(DatabaseNotification $notification): NotificationDto
    {
        return $this->getTransformer($notification->type)->transform($notification);
    }

    /**
     * @throws \Exception
     */
    private function getTransformer(string $notificationType): NotificationTransformerContract
    {
        return match ($notificationType) {
            ChapterCreated::class => new ChapterNotificationTransformer(),
            default => throw new \Exception('Не поддерживаемый тип нотификаций'),
        };
    }
}
