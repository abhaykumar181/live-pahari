<x-mail::message>
# Confirmation Rejected

Dear {{ $booking->name }},<br>
Your confirmation request for {{ $property->title }} has been rejected.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
