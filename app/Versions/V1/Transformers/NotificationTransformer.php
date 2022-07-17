<?php

namespace App\Versions\V1\Transformers;

use App\Notifications\ChapterCreated;
use App\Versions\V1\Dto\NotificationDto;
use App\Versions\V1\Transformers\ChapterNotificationTransformer;
use App\Versions\V1\Transformers\NotificationTransformerContract;
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
    private function getTransformer(string $notificationType): \App\Versions\V1\Transformers\NotificationTransformerContract
    {
        return match ($notificationType) {
            ChapterCreated::class => new \App\Versions\V1\Transformers\ChapterNotificationTransformer(),
            default => throw new \Exception('Не поддерживаемый тип нотификаций'),
        };
    }
}
