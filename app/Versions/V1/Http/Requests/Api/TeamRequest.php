<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $name
*/
class TeamRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => ['required', 'string']
        ];
    }
}
