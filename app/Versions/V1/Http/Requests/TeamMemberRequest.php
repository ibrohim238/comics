<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $roles
 */
class TeamMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'roles' => ['array', 'exists:roles,id']
        ];
    }
}
