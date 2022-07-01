<?php

namespace App\Versions\V1\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
/**
 * @property-read int $volume
 * @property-read int $number
 * @property-read string $name
*/
class ChapterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'volume' => ['required', 'int'],
            'number' => ['required', 'int'],
            'name' => ['required', 'string'],
        ];
    }
}
