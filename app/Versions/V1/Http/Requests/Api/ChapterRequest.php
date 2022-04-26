<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @property-read int $volume
 * @property-read int $number
 * @property-read string $name
 * @property-read bool $is_paid
 * @property-read array $images
*/
class ChapterRequest extends FormRequest
{
    public function rules()
    {
        return [
            'volume' => ['required', 'int'],
            'number' => ['required', 'int'],
            'name' => ['required', 'string'],
            'is_paid' => ['required', 'boolean'],
            'images.*' => ['required', 'image'],
        ];
    }
}
