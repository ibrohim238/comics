<?php

namespace App\Versions\V1\Http\Requests\Api;

use App\Enums\FilterTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $name
 * @property-read string $description
 * @property-read string $type
*/
class FilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'type' => [new Enum(FilterTypeEnum::class)]
        ];
    }
}
