<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'service.name' => 'required|min:1|max:255|unique:App\Models\Service,name',
            'service.service_category_id' => 'required|exists:App\Models\ServiceCategory,id',
            'service.attention' => 'nullable',
            'service.price' => 'nullable',
            'service.price_per_hour' => 'nullable',
            'service.price_per_day' => 'nullable',
        ];
    }
}
