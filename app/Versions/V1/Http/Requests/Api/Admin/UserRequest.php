<?php

namespace App\Versions\V1\Http\Requests\Api\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }
}
