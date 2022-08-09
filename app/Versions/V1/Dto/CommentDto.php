<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\CommentRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentDto extends DataTransferObject
{
    public string $content;
    public int $user_id;
    public ?int $parentId;

    public static function fromRequest(CommentRequest $request): self
    {
        return new self($request->validated() + [
            'user_id' => $request->user()->id
        ]);
    }
}
