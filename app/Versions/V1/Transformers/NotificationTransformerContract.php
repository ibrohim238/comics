<?php

namespace App\Versions\V1\Transformers;

use App\Dto\NotificationDto;
use Illuminate\Notifications\DatabaseNotification;

interface NotificationTransformerContract
{
    public function transform(DatabaseNotification $notification): NotificationDto;

    public function getImage(): string;

    public function getUrl(): string;

    public function getMessage(): string;

    public function getGroup(): int;
}
