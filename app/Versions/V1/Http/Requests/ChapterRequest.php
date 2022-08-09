<?php

namespace App\Versions\V1\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property-read int $volume
 * @property-read int $number
 * @property-read string $name
 * @property-read array $images
 * @property-read Carbon $free_at
 * @property-read int $manga_id
 * @property-read int $team_id
*/
class ChapterRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'volume' => ['required', 'int'],
            'number' => ['required', 'int'],
            'name' => ['required', 'string'],
            'media.*' => ['nullable', 'image'],
            'free_at' => ['nullable', 'date'],
            'price' => ['required', 'int']
        ];
        return
            match ($this->getMethod()) {
                'POST' => $rules + [
                        'manga' => ['required', 'string', 'exists:mangas,slug'],
                        'team_id' => ['nullable', 'int', 'exists:teams,id'],
                ],
                'PATCH' => $rules,
            };
    }
}
