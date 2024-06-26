<?php

declare(strict_types=1);

namespace App\Http\Requests\ServiceCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        dump($this);
        return [
            'serviceCategory.name' => [
                'required',
                'min:1',
                'max:255',
                Rule::unique('App\Models\ServiceCategory', 'name')
                    ->ignore($this->route()->serviceCategory)
            ],
        ];
    }
}
