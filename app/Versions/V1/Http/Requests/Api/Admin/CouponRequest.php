<?php

namespace App\Versions\V1\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @property-read int $volume
 * @property-read int $number
 * @property-read string $name
 * @property-read bool $is_paid
 * @property-read array $images
*/
class CouponRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => ['required', 'string'],
            'data' => ['nullable', 'json'],
            'limit' => ['nullable', 'int'],
            'ends_at' => ['nullable', 'date'],
        ];
    }
}
