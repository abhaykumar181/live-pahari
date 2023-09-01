



@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}

{{-- Message --}}

<span>Dear {{ $property->ownerName }}, </span></br>
You have a booking confirmation request from {{ $booking->name }} </br>

<a href="http://127.0.0.1:8000/bookings/confirmation/{{md5($confirmationItem->id)}}"> View Details </a>


{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot

@endcomponent
