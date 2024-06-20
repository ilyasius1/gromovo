<p>Уважаемый(ая) {{ $customerProfile->full_name }}.</p>
<p>Вы забронировали {{ $cottage->name }} площадью {{ $cottage->area }}м<sup>2</sup><br>
    Дата заезда: {{ $booking->start }} с 18:00<br>
    Дата выезда: {{ $booking->end }} до 16:00<br>
    Общая стоимость: {{ $booking->amount }} руб.
</p>
<p>Вам необходимо оплатить договор аренды №{{ $booking->contract_number }} в течение суток</p>
<p><a href="{{ env('FRONTEND_URL') }}/bookings/payment?contract_no={{ $booking->contract_number }}">Страница оплаты</a> </p>
