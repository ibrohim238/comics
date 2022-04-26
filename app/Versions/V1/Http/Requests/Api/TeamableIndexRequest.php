<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read string $teamable
*/
class TeamableIndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            'teamable' => ['string', 'nullable']
        ];
    }
}
