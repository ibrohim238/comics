<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read $body
 * @property-read $parent_id
*/

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'body' => ['string'],
            'parent_id' => ['integer'],
        ];
    }
}
