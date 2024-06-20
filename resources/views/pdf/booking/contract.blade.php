<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style>
    * {
        font-family: "DejaVu Sans", sans-serif;
    }
</style>
<h1>Договор #{{ $booking->contract_number }}</h1>
<p>От {{ $booking->created_at->format('d.m.Y') }}</p>
<p>{{ $cottage->name }}</p>
<p>{{ $profile->full_name }}</p>
