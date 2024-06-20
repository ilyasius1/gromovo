<?php

declare(strict_types=1);

namespace App\Http\Requests\Period;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePeriodRequest extends FormRequest
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
        $this->merge([
            'period' => array_merge($this->period, [
                'is_holiday' => (bool)($this->period['is_holiday'] ?? false),
                'is_active' => (bool)($this->period['is_active'] ?? false)
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
            'period.name' => [
                'required',
                'min:1',
                'max:255',
                Rule::unique('App\Models\Period', 'name')
                    ->ignore($this->route()->period)
            ],
            'period.start' => 'required',
            'period.end' => 'required',
            'period.is_holiday' => 'boolean',
            'period.is_active' => 'boolean'
        ];
    }
}
