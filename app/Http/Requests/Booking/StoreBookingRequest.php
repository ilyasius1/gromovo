<?php

declare(strict_types=1);

namespace App\Http\Requests\Booking;

use App\Models\Cottage;
use App\Models\CustomerProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    private Cottage $cottage;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->cottage = Cottage::findOrFail((int)$this->booking['cottage_id']);
        $this->merge([
            'booking' => array_merge($this->booking, [
                'main_places' => array_key_exists('main_places', $this->booking) ? (int)$this->booking['main_places'] : (int)$this->cottage->mainPlaces,
                'additional_places' => (int)$this->booking['additional_places'],
                'children_places' => (int)$this->booking['children_places'],
                'news_subscription' => (bool)($this->booking['news_subscription'] ?? false),
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
        $mainPlaces = $this->cottage->cottageType->main_places;
        $additionalPlaces = $this->cottage->cottageType->additional_places;
        $childrenPlaces = $this->cottage->cottageType->children_places;
        return [
            'booking.cottage_id' => 'required|exists:App\Models\Cottage,id',
            'booking.customer_profile_id' => [
                Rule::requiredIf(fn() => $this->user()?->inRole('admin')),
                Rule::exists(CustomerProfile::class, 'id')
            ],
            'booking.full_name' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'max:255'
            ],
            'booking.phone' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'numeric',
                'digits:10',
            ],
            'booking.email' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'email',
            ],
            'booking.document_number' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'size:10'
            ],
            'booking.document_issued_by' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'max:200'
            ],
            'booking.document_issued_at' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'date',
                'before:now',
                'after:booking.birthdate'
            ],
            'booking.address' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'max:255'
            ],
            'booking.birthdate' => [
                'nullable',
                'before:now',
                'before:booking.document_issued_at'
            ],
            'booking.main_places' => "required|numeric|max:$mainPlaces",
            'booking.additional_places' => "sometimes|numeric|max:$additionalPlaces",
            'booking.children_places' => "sometimes|numeric|max:$childrenPlaces",
            'booking.news_subscription' => [
                Rule::requiredIf(fn() => !$this->user()?->inRole('admin')),
                'boolean'
            ],
            'booking.start' => 'required|date|after_or_equal:tomorrow',
            'booking.end' => 'required|date|after:booking.start',
            'booking.amount' => 'required|int'
        ];
    }
}
