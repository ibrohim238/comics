<?php

namespace App\Dto;

use App\Caster\TagTypeEnumCaster;
use App\Enums\TagTypeEnum;
use App\Versions\V1\Http\Requests\TagRequest;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class TagDto extends DataTransferObject
{
    public string $name;
    public ?string $description;
    #[CastWith(TagTypeEnumCaster::class)]
    public TagTypeEnum $type;

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(TagRequest $request): TagDto
    {
        return new self($request->validated());
    }
}
