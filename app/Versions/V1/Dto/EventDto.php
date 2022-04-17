<?php

namespace App\Versions\V1\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class EventDto extends DataTransferObject
{
    public int $user_id;
    public string $type;

    public static function fromArray(array $data): EventDto
    {
        return new self([
            'user_id' => $data['user_id'],
            'type' => $data['type'],
        ]);
    }
}
