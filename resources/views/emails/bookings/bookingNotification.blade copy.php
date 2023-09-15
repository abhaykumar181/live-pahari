<x-mail::message>

Dear *{{ $bookingUsername }}*,

We are thrilled to confirm your booking for *{{ $tourName->title }}*! Get ready for an incredible experience. Below are all the details you'll need. Simply present this email on the day of your arrival.
# Booking Details
<x-mail::table>
| Booking Code | Check-in    | Check-out    | Total     | Status        |
|:-------------|:------------|:-------------|:----------|--------------:|
| {{ $bookingCode }} | {{ $checkInDate }} | {{ $checkOutDate }} | ${{ $orderTotalPrice->price }} | {{ ucwords($bookingStatus) }} |
</x-mail::table>

# Order Summary
<x-mail::table>
|  Order Items  | Guests    | Rate Per Unit    |  Total  |
|:--------------|:----------|:-----------------|:--------|
| {{ $tourName->title }} | {{ $guests }} | ${{ $packagePerUnitRate }} | ${{ $packagePerUnitRate * $guests }} |
@foreach($bookingItems as $item)
@php
    $addonId = $item->objectId;
    $addon = App\Models\Addons::find($addonId);
@endphp
| {{ $addon->title }} | {{ $guests }} | ${{ $item->baseprice }} | ${{ $item->totalPrice }} |
@endforeach
| | | |<strong> Total: </strong>${{ $totalPrice }} |

</x-mail::table>


@if(sizeof($pendingConfirmations))
# Property Details
<x-mail::table>
| Property Name | Confirmation | Payment |
|:--------------|:-------------|:--------|
@foreach($pendingConfirmations as $pendingConfirmation)
@php
    $propertyId = $pendingConfirmation->propertyId;
    $property = App\Models\Properties::find($propertyId);
@endphp
| {{ $property->title }} | {{ ucwords($pendingConfirmation->confirmation) }} | {{ ucwords($pendingConfirmation->payment) }}|
@endforeach
</x-mail::table>
@endif

</x-mail::message>