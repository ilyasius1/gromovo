<?php

declare(strict_types=1);

namespace App\Http\Requests\ServiceCategory;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceCategoryRequest extends FormRequest
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
        return [
            'serviceCategory.name' => 'required|min:1|max:255|unique:App\Models\ServiceCategory,name',
        ];
    }
}
