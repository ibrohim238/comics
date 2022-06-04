<?php

namespace App\Versions\V1\Http\Requests\Api;

use App\Enums\RatesTypeEnum;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read int $value
 * @property-read string $type
 */
class RateRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
           'type' => $this->segment(3),
        ]);
    }

    /**
     * @throws Exception
     */
    public function rules(): array
    {
        $value = match ($this->type) {
            RatesTypeEnum::LIKE_TYPE->value => ['required', 'boolean'],
            RatesTypeEnum::RATING_TYPE->value => ['required', 'numeric', 'min:0', 'max:5'],
            default => throw new Exception('Unexpected match value'),
        };

        return [
            'value' => $value,
            'type' => [new Enum(RatesTypeEnum::class)],
        ];
    }
}
