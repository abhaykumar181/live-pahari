<x-mail::message>
# Confirmation Request
 
Dear {{ $property->ownerName }}, </br>
You have a booking confirmation request from {{ $booking->name }} </br>

<a href="http://127.0.0.1:8000/bookings/confirmation/{{md5($confirmationItem->id)}}">View Details</a>
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>  