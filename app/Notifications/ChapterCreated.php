<?php

namespace App\Notifications;

use App\Models\Chapter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChapterCreated extends Notification
{
    use Queueable;

    public function __construct(
y        public Chapter $chapter
    ) {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'chapter_id' => $this->chapter->id,
            'group_id' => $this->chapter->manga_id,
        ];
    }
}
