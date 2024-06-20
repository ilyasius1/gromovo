<?php

declare(strict_types=1);

namespace App\Http\Requests\Reservation;

use App\Models\CustomerProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReservationRequest extends FormRequest
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
            'reservation' => array_merge($this->reservation, [
                'news_subscription' => (bool)($this->reservation['news_subscription'] ?? false),
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
            'reservation.cottage_id' => 'required|exists:App\Models\Cottage,id',
            'reservation.customer_profile_id' => [
                Rule::requiredIf(fn() => $this->user()?->isAdmin),
                Rule::exists(CustomerProfile::class, 'id')
            ],
            'reservation.full_name' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'max:255'
            ],
            'reservation.phone' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'numeric',
                'digits:10',
            ],
            'reservation.email' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'email',
            ],
            'reservation.document_number' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'size:10'
            ],
            'reservation.document_issued_by' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'max:200'
            ],
            'reservation.document_issued_at' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'date',
                'before:now',
                'after:reservation.birthdate'
            ],
            'reservation.address' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'max:255'
            ],
            'reservation.birthdate' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'before:now',
                'before:reservation.document_issued_at'
            ],
            'reservation.news_subscription' => [
                Rule::requiredIf(fn() => !$this->user()?->isAdmin),
                'boolean'
            ],
            'reservation.start' => 'required|date|after_or_equal:tomorrow',
            'reservation.end' => 'required|date|after:reservation.start',
            'reservation.amount' => 'required|int'
        ];
    }
}
