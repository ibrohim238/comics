<?php

namespace App\Versions\V1\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $team_id
*/
class ChapterIndexRequest extends FormRequest
{
    public function rules()
    {
        return [
            'team_id' => ['nullable', 'int']
        ];
    }
}
