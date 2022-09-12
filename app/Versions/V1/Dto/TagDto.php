<?php

namespace App\Versions\V1\Dto;

use App\Enums\TagTypeEnum;
use App\Versions\V1\Http\Requests\TagRequest;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagDto extends DataTransferObject
{
    public string $name;
    public ?string $description;
    #[CastWith(EnumCaster::class, TagTypeEnum::class)]
    public TagTypeEnum $type;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(TagRequest $request): TagDto
    {
        return new self($request->validated());
    }
}
