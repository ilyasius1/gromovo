<?php

declare(strict_types=1);

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePackageRequest extends FormRequest
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
            'package.name' => [
                'required',
                'min:1',
                'max:255',
                Rule::unique('App\Models\Package', 'name')
                    ->ignore($this->route()->package)
            ],
            'package.days_start' => 'required|numeric|min:1|max:7',
            'package.days_end' => 'required|numeric|min:1|max:7',
            'package.nights' => 'required|numeric|min:1|max:366'
        ];
    }
}
