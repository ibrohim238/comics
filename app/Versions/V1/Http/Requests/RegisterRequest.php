<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read string $username
 * @property-read string $email
 * @property-read string $password
*/
class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:30', 'regex:/(^([a-zA-Z]+)(\d+)?$)/u', 'unique:users'],
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,'.Auth::id(),
            'password' => 'sometimes|required|string|min:8|max:255|confirmed',
        ];
    }
}
