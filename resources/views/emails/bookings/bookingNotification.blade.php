@component('mail::layout')
{{-- Header --}}
@slot('header')
    @component('mail::header', ['url' => config('app.url')])
        {{ config('app.name') }}
    @endcomponent
@endslot

{{-- Body --}}

{{-- Message --}}

Dear <span style="font-weight:bold">{{ $bookingUsername }}</span>,</br>
We are happy to inform you that your booking for {{$tourName->title}} is confirmed! Get ready to create some unforgettable memories. We’ve made things easy for you and included all of your booking details in this very email. All you need to do is show us this email on the day you arrive, and you’ll be good to go!



@component('mail::table')
<span style="font-weight:bold;padding:2px;">Booking Details</span>
|Booking Code|Check-in|Check-out|Total|Status|
|:-------------|:-------------|:---------------|:------|:-------|
|{{ $bookingCode }}|{{ $checkInDate }}|{{ $checkOutDate }}|${{ $orderTotalPrice->price }}|{{ $bookingStatus }}|
@endcomponent

@component('mail::table')
<span style="font-weight:bold;padding:2px;">Order Summary</span>
|              |              |                |           |
|:-------------|:-------------|:---------------|:----------|
|{{ $tourName->title }}|{{ $guests }}|{{ $packagePerUnitRate }}|{{ $packagePerUnitRate * $guests }}|

    @foreach($bookingItems as $item)
        @php
            $addonId = $item->objectId;
            $addon = App\Models\Addons::find($addonId);
        @endphp
        |{{ $addon->title }}|{{ $guests }}|{{ $item->baseprice }}|{{ $item->totalPrice }}|
    @endforeach

Total: {{ $totalPrice }}

@endcomponent

@php if(sizeof($pendingConfirmations)){ @endphp
@component('mail::table')
<span style="font-weight:bold;padding:2px;">Confirmation Pending Property Details</span>
        |Property Name |Confirmation  |Payment         |
        |:-------------|:-------------|:---------------|
    @foreach($pendingConfirmations as $pendingConfirmation)
        @php
            $propertyId = $pendingConfirmation->propertyId;
            $property = App\Models\Properties::find($propertyId);
        @endphp
        |{{ $property->title }}|{{ $pendingConfirmation->confirmation }}|{{ $pendingConfirmation->payment }}|
    @endforeach
@endcomponent
@php } @endphp 




{{-- Subcopy --}}
@isset($subcopy)
    @slot('subcopy')
        @component('mail::subcopy')
            {{ $subcopy }}
        @endcomponent
    @endslot
@endisset

{{-- Footer --}}
@slot('footer')
    @component('mail::footer')
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    @endcomponent
@endslot

@endcomponent
