<?php

declare(strict_types=1);

namespace App\Http\Requests\Booking;

use App\Enums\BookingStatus;
use App\Models\Cottage;
use App\Models\CustomerProfile;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class UpdateBookingRequest extends FormRequest
{

    private Cottage $cottage;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->inRole('admin');
    }

    protected function prepareForValidation(): void
    {
        $this->cottage = Cottage::findOrFail((int)$this->booking['cottage_id']);
        $this->merge([
            'booking' => array_merge($this->booking, [
                'main_places' => array_key_exists('main_places', $this->booking) ? (int)$this->booking['main_places'] : (int)$this->cottage->mainPlaces,
                'start' => Date::make($this->booking['start']),
                'end' => Date::make($this->booking['end']),
                'pay_before' => Date::make($this->booking['pay_before'])
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
            'booking.customer_profile_id' => 'required|exists:App\Models\CustomerProfile,id',
            'booking.main_places' => "required_with:booking.cottage_id|numeric|max:$mainPlaces",
            'booking.additional_places' => "required_with:booking.cottage_id|numeric|max:$additionalPlaces",
            'booking.children_places' => ["required_with:booking.cottage_id|numeric", "max:$childrenPlaces"],
            'booking.start' => 'required|date',
            'booking.end' => 'required|date|after:booking.start',
            'booking.amount' => 'required',
            'booking.pay_before' => 'required|date',
            'booking.status' => ['required', Rule::enum(BookingStatus::class)]
        ];
    }
}
