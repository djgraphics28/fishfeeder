@component('mail::message')
# High Temperature Alert!

A high temperature has been detected at **{{ $location }}**.

The current temperature is **{{ $temperature }}°C**, which exceeds the safe limit.

Please take appropriate action immediately to ensure safety.

Thanks,  
{{ config('app.name') }}
@endcomponent
