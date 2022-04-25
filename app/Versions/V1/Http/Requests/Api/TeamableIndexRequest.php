<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TeamableIndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            'teamable' => ['string', 'nullable']
        ];
    }
}
