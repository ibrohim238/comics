<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $role
*/
class TeamMemberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'role' => ['required', 'string']
        ];
    }
}
