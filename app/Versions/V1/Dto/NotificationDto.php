<?php

namespace App\Versions\V1\Dto;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class NotificationDto extends DataTransferObject
{
    public string $image;
    public string $message;
    public string $url;
    public int $groupId;
    public ?Carbon $readAt;
    public Carbon $createdAt;
}
