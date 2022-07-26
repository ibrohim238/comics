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
class RateRequest extends FormRequest
{
    /**
     * @throws Exception
     */
    public function rules(): array
    {
        $rules = match ($this->type) {
            RateTypeEnum::RATING_TYPE->value => [
                'value' => ['required', 'numeric', 'min:0', 'max:5'],
            ],
            RateTypeEnum::LIKE_TYPE->value => [
                'value' => ['required', 'boolean']
            ],
            RateTypeEnum::VOTE_TYPE->value => []
        };



        return match ($this->method()) {
            'POST' => $rules,
            'DELETE' => []
        };
    }
}
