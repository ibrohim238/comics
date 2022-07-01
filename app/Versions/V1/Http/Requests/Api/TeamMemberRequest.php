<?php

namespace App\Versions\V1\Http\Requests\Api;

use App\Enums\TeamRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $role
 */
class TeamMemberRequest extends FormRequest
{
    public function rules()
    {
        return [
            'role' => [new Enum(TeamRoleEnum::class)]
        ];
    }
}
