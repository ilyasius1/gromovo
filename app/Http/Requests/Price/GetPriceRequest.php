<?php

namespace App\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

class GetPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'additional_places' => (int)$this->additional_places,
            'children_places' => (int)$this->children_places
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
            'cottage_id' => 'required|exists:App\Models\Cottage,id',
            'start' => 'required|date',
            'end' => 'required|date|after:start',
            'additional_places' => 'numeric',
            'children_places' => 'numeric',
        ];
    }
}
