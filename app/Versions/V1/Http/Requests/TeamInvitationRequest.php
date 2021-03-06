<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $userId
 * @property-read string $data
*/
class TeamInvitationRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'int', 'exists:users,id'],
            'ends_at' => ['nullable', 'date', 'after:today'],
            'data' => ['required', 'json']
        ];
    }
}
