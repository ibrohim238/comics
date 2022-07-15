<?php

namespace App\Dto;

use App\Versions\V1\Http\Requests\CommentRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentDto extends DataTransferObject
{
    public string $content;
    public int $user_id;
    public ?int $parentId;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(CommentRequest $request): self
    {
        return new self(array_merge($request->validated(), [
            'user_id' => $request->user()->id
        ]));
    }
}
