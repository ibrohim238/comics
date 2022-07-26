<?php

namespace App\Versions\V1\Http\Requests;

use App\Enums\RateTypeEnum;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read int $value
 * @property-read string $type
 */
class RatingRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'value' => ['required', 'numeric', 'min:0', 'max:5'],
        ];
    }
}
