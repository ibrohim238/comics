<?php

namespace App\Versions\V1\Http\Requests;

use App\Enums\TagTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $name
 * @property-read string $description
 * @property-read string $type
*/
class TagRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'type' => [new Enum(TagTypeEnum::class)]
        ];
    }
}
