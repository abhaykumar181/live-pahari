
<header>Dear {{ $property->ownerName }}, </header></br>
You have a booking confirmation request from {{ $booking->name }} </br>
<a href="http://127.0.0.1:8000/bookings/confirmation/{{md5($confirmationItem->id)}}" style="color:blue;">View Details</a>
