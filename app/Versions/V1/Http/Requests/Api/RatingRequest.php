<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $rating
 */
class RatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'min:0', 'max:5'],
        ];
    }
}
