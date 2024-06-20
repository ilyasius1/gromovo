<?php

declare(strict_types=1);

namespace App\Http\Requests\CottageType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCottageTypeRequest extends FormRequest
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
            'cottageType.name' => [
                'required',
                'min:1',
                'max:255',
                Rule::unique('App\Models\CottageType', 'name')
                    ->ignore($this->route()->cottageType)
            ],
        ];
    }
}