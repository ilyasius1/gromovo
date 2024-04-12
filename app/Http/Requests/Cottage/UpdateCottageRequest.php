<?php

declare(strict_types=1);

namespace App\Http\Requests\Cottage;

use Illuminate\Validation\Rule;

/**
 * @property array $cottage
 */
class UpdateCottageRequest extends StoreCottageRequest
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
            'cottage.name' => [
                'required',
                'min:1',
                'max:255',
                Rule::unique('App\Models\Cottage', 'name')
                    ->ignore($this->route()->cottage)
            ],
            'cottage.cottage_type_id' => 'required|exists:App\Models\CottageType,id',
            'cottage.description' => 'nullable',
            'cottage.area' => 'numeric|min:0',
            'cottage.floors' => 'numeric|min:0',
            'cottage.bedrooms' => 'numeric|min:0',
            'cottage.single_beds' => 'numeric|min:0',
            'cottage.double_beds' => 'numeric|min:0',
            'cottage.additional_single_beds' => 'numeric|min:0',
            'cottage.additional_double_beds' => 'numeric|min:0',
            'cottage.bathrooms' => 'numeric|min:0',
            'cottage.showers' => 'numeric|min:0',
            'cottage.sauna' => 'boolean',
            'cottage.fireplace' => 'boolean',
            'cottage.floor1_features' => 'nullable',
            'cottage.floor2_features' => 'nullable',
            'cottage.floor3_features' => 'nullable',
            'cottage.is_active' => 'boolean',
            'images.main' => 'nullable',
            'images.schema' => 'nullable',
            'images.winter' => 'nullable',
            'images.summer' => 'nullable'
        ];
    }
}
