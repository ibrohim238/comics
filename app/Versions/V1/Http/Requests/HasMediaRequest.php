<?php

namespace App\Versions\V1\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HasMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'media_urls.*' => ['nullable', 'url'],
            'media.*' => ['nullable', 'file'],
            'xml' => ['nullable', 'file', 'mimes:xml']
        ];
    }
}
