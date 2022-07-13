<?php

namespace App\Versions\V1\Http\Requests;

use App\Enums\RatesTypeEnum;
use Exception;
use Illuminate\Foundation\Http\FormRequest;

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
        return match ($this->segment(3)) {
            RatesTypeEnum::RATING_TYPE->value => [
                'value' => ['required', 'numeric', 'min:0', 'max:5'],
            ],
            RatesTypeEnum::LIKE_TYPE->value => [
                'value' => ['required', 'boolean'],
            ],
            RatesTypeEnum::VOTE_TYPE->value => [],
            default => throw new Exception('Unexpected match value'),
        };
    }
}
