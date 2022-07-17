<?php

namespace App\Versions\V1\Transformers;

use App\Models\Chapter;
use App\Versions\V1\Dto\NotificationDto;
use App\Versions\V1\Transformers\NotificationTransformerContract;
use Illuminate\Notifications\DatabaseNotification;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use function route;

class ChapterNotificationTransformer implements NotificationTransformerContract
{
    private Chapter $chapter;

    /**
     * @throws UnknownProperties
     */
    public function transform(DatabaseNotification $notification): NotificationDto
    {
        $this->setChapter($notification->data['chapter_id']);

        return new NotificationDto(
            image: $this->getImage(),
            message: $this->getMessage(),
            url: $this->getUrl(),
            groupId: $this->getGroup(),
            readAt: $notification->read_at,
            createdAt: $notification->created_at,
        );
    }

    public function getImage(): string
    {
        return $this->chapter->manga->getFirstMediaUrl();
    }

    public function getUrl(): string
    {
        return route('manga.show', $this->chapter->manga_id);
    }

    public function getMessage(): string
    {
        return sprintf(
            "%s добавлен %s том %s глава в %s доступе.",
            $this->chapter->manga->name,
            $this->chapter->volume,
            $this->chapter->number,
            $this->chapter->is_paid ? 'бесплатном' : 'платном'
        );
    }

    public function getGroup(): int
    {
        return $this->chapter->manga_id;
    }

    private function setChapter(int $chapterId): void
    {
        $this->chapter = Chapter::findOrFail($chapterId);
        $this->chapter->load('manga');
    }
}
