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
        return match ($this->type) {
            RatesTypeEnum::RATING_TYPE->value => [
                'value' => ['required', 'numeric', 'min:0', 'max:5'],
                'type' => [new Enum(RatesTypeEnum::class)]
            ],
            RatesTypeEnum::LIKE_TYPE->value => [
                'value' => ['required', 'boolean'],
                'type' => [new Enum(RatesTypeEnum::class)]
            ],
            RatesTypeEnum::VOTE_TYPE->value => [
                'type' => [new Enum(RatesTypeEnum::class)]
            ],
            default => throw new Exception('Unexpected match value'),
        };
    }
}
