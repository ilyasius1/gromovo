<?php

declare(strict_types=1);

namespace App\Http\Requests\Price;

use Illuminate\Foundation\Http\FormRequest;

class IndexPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
//    public function authorize(): bool
//    {
//        return true;
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cottage' => 'numeric|exists:App\Models\Cottage,id',
            'period' => 'numeric|exists:App\Models\Period,id',
        ];
    }
}
