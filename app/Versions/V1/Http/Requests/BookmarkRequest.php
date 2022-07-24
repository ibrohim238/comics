<?php

namespace App\Versions\V1\Http\Requests;

use App\Enums\BookmarkTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $type
*/
class BookmarkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(BookmarkTypeEnum::class)],
        ];
    }
}
