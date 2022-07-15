<?php

namespace App\Versions\V1\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

/**
 * @property-read string $name
 * @property-read string $description
 * @property-read Carbon $published_at
 * @property-read bool $is_published
 * @property-read array $tags
 * @property-read UploadedFile $image
*/
class MangaRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'published_at' => $this->is_published ? Carbon::now() : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:255'],
            'description' => ['required', 'string', 'min:4', 'max:625'],
            'published_at' => ['nullable', 'date'],
            'tags' => ['required', 'array', 'exists:tags,id'],
            'image' => ['nullable', 'image'],
        ];
    }
}
