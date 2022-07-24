<?php

namespace App\Versions\V1\Http\Requests\Admin;

use App\Enums\RolePermissionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

/**
 * @property-read string $password
 * @property-read string $role
*/
class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'sometimes|required|string|min:8|max:255',
            'role' => ['required', new Enum(RolePermissionEnum::class)]
        ];
    }
}
