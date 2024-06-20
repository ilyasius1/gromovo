<?php

declare(strict_types=1);

namespace App\Http\Requests\CustomerProfile;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerProfileRequest extends FormRequest
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
        return $this->merge([
            'customerProfile' => array_merge($this->customerProfile, [
                'news_subscription' => (bool)($this->customerProfile['news_subscription'] ?? false),
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
            'customerProfile.full_name' => 'required|max:255',
            'customerProfile.phone' => 'required|numeric|digits:10',
            'customerProfile.email' => 'required|email|unique:\App\Model\CustomerProfile,email',
            'customerProfile.document_number' => 'required|size:10',
            'customerProfile.document_issued_by' => 'required|max:200',
            'customerProfile.document_issued_at' => 'required|date|before:now|after:customerProfile.birthdate',
            'customerProfile.address' => 'required|max:255',
            'customerProfile.birthdate' => 'required|date|before:customerProfile.document_issued_at',
            'customerProfile.news_subscription' => 'boolean'
        ];
    }
}
