<?php

declare(strict_types=1);

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreGalleryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'gallery' => array_merge($this->gallery, [
                'name_eng' => Str::slug($this->gallery['name'])
            ])
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gallery.name' => 'required|min:1|max:255|unique:App\Models\Gallery,name',
            'gallery.name_eng' => 'string|min:1|max:255',
            'gallery.description' => 'nullable|string|min:1|max:255',
            'images' => 'nullable'
        ];
    }
}
