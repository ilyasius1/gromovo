<?php

declare(strict_types=1);

namespace App\Http\Requests\Reservation;

use App\Enums\ReservationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'reservation' => array_merge($this->reservation, [
                'start' => Date::make($this->reservation['start']),
                'end' => Date::make($this->reservation['end']),
                'pay_before' => Date::make($this->reservation['pay_before'])
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
            'reservation.cottage_id' => 'required',
            'reservation.customer_profile_id' => 'required',
            'reservation.start' => 'required|date',
            'reservation.end' => 'required|date|after:reservation.start',
            'reservation.amount' => 'required',
            'reservation.pay_before' => 'required|datetime',
            'reservation.status' => ['required', Rule::enum(ReservationStatus::class)]
        ];
    }
}
