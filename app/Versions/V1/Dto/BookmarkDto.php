<?php

namespace App\Versions\V1\Dto;

use App\Enums\BookmarkTypeEnum;
use App\Versions\V1\Http\Requests\BookmarkRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;

class BookmarkDto extends BaseDto
{
    #[CastWith(EnumCaster::class, BookmarkTypeEnum::class)]
    public BookmarkTypeEnum $type;

    public static function fromRequest(BookmarkRequest $request): BookmarkDto
    {
        return new self($request->validated());
    }
}