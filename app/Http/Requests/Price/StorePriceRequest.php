<?php

declare(strict_types=1);

namespace App\Http\Requests\Price;

use App\Models\CottageType;
use App\Models\Package;
use App\Models\Period;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class StorePriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->inRole('admin');
    }

    /**
     * Prepare the data for validation.
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $cottageType = CottageType::findOrFail($this->price['cottage_type_id']);
        $period = Period::findOrFail($this->price['period_id']);
        $package = Package::findOrFail($this->price['package_id']);
        $start = CarbonImmutable::make($period->start)->format('d.m.Y');
        $end = CarbonImmutable::make($period->end)->format('d.m.Y');
        $name = "$cottageType->name цена за $package->name с $start по $end";
        $this->merge([
            'price' => array_merge($this->price, [
                'name' => $name,
                'rate' => (int)$this->price['rate'],
                'is_active' => (bool)($this->price['is_active'] ?? false),
            ]),
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
            'price.name' => 'max:255|unique:App\Models\Price,name',
            'price.cottage_type_id' => 'required|exists:App\Models\CottageType,id',
            'price.period_id' => 'required|exists:App\Models\Period,id',
            'price.package_id' => 'required|exists:App\Models\Package,id',
            'price.rate' => 'numeric|min:0',
            'price.is_active' => 'boolean',
        ];
    }
}
