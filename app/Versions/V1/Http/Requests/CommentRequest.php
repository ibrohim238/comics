<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $body
 * @property-read integer $parent_id
*/

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
            'parent_id' => ['nullable', 'integer'],
        ];
    }
}
