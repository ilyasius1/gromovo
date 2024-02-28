<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property array $cottage
 */
class StoreCottageRequest extends FormRequest
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
            'cottage' => array_merge($this->cottage, [
                'area' => (int)$this->cottage['area'],
                'floors' => (int)$this->cottage['floors'],
                'bedrooms' => (int)$this->cottage['bedrooms'],
                'single_beds' => (int)$this->cottage['single_beds'],
                'double_beds' => (int)$this->cottage['double_beds'],
                'additional_single_beds' => (int)$this->cottage['additional_single_beds'],
                'additional_double_beds' => (int)$this->cottage['additional_double_beds'],
                'bathrooms' => (int)$this->cottage['bathrooms'],
                'showers' => (int)$this->cottage['showers'],
                'sauna' => (bool)($this->cottage['sauna'] ?? false),
                'fireplace' => (bool)($this->cottage['fireplace'] ?? false),
                'is_active' => (bool)($this->cottage['is_active'] ?? false),
                'floor1_features' => $this->explodeFeatures(1),
                'floor2_features' => $this->explodeFeatures(2),
                'floor3_features' => $this->explodeFeatures(3)
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
            'cottage.name' => 'required|min:1|max:255|unique:App\Models\Cottage,name',
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

    /**
     * Explode floor%_features field
     *
     * @param int|string $floor
     * @return array
     */
    protected function explodeFeatures(int|string $floor): array
    {
        $field = 'floor' . $floor . '_features';
        return isset($this->$field)
            ?
            explode("\n", str_replace("\r\n", "\n", $this->$field))
            : [];
    }
}
