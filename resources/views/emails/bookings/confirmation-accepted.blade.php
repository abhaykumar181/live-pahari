<x-mail::message>
# Confirmation Accepted

Dear {{ $booking->name }},
Your confirmation for {{ $property->title }} has been accepted.<br>
Now you can pay the property amount. Click the below button to Pay.

<x-mail::button :url="''">
Pay now
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
