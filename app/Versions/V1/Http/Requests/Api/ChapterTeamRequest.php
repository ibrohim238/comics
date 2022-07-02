<?php

namespace App\Versions\V1\Http\Requests\Api;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read Carbon $free_at
 * @property-read array $images
 * @property-read int $teamId
 */
class ChapterTeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'teamId' => ['required', 'int', 'exists:teams,id'],
            'image.*' => ['nullable', 'image'],
            'free_at' => ['nullable', 'date'],
        ];
    }
}
