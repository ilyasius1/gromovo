<?php

declare(strict_types=1);

namespace App\Http\Requests\CustomerProfile;

use App\Models\CustomerProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerProfileRequest extends FormRequest
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
            'customerProfile.email' => [
                'required',
                'email',
                Rule::unique(CustomerProfile::class, 'email')
                    ->ignore($this->route()->customerProfile)
            ],
            'customerProfile.document_number' => 'required|size:10',
            'customerProfile.document_issued_by' => 'required|max:20',
            'customerProfile.document_issued_at' => 'required',
            'customerProfile.address' => 'required',
            'customerProfile.birthdate' => 'required',
            'customerProfile.news_subscription' => 'boolean'
        ];
    }
}
