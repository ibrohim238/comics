<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read array $ids
*/
class NotificationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'ids' => ['sometimes', 'array'],
            'ids.*' => ['required', 'string', 'exists:notifications,id']
        ];
    }
}