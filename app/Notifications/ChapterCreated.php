<?php

namespace App\Notifications;

use App\Models\Chapter;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ChapterCreated extends Notification
{
    use Queueable;

    public function __construct(
        public array $data
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
            'image' => $this->data['image'],
            'message' => $this->data['message'],
            'url' => $this->data['url'],
            'group_id' => $this->data['group_id']
        ];
    }
}
