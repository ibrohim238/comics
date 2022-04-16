<?php

namespace App\Versions\V1\Dto;

use App\Versions\V1\Http\Requests\Api\CommentRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CommentDto extends DataTransferObject
{
    public ?int $parentId;
    public string $body;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(CommentRequest $request): self
    {
        return new self($request->validated());
    }
}
