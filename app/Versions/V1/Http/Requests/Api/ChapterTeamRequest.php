<?php

namespace App\Versions\V1\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read Carbon $free_at
 * @property-read array $images
*/
class ChapterTeamRequest extends FormRequest
{
    public function rules()
    {
        return [
            'free_at' => ['required', 'date'],
            'images' => ['required', 'array', 'image'],
        ];
    }
}
