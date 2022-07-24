<?php

namespace App\Versions\V1\Http\Requests;

use App\Enums\TeamRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $roles
 */
class TeamMemberRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'role' => ['required', new Enum(TeamRoleEnum::class)]
        ];
    }
}
