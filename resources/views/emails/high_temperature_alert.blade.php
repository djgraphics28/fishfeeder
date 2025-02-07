@component('mail::message')
# High Temperature Alert

Dear Admin,

A high temperature has been detected in **{{ $fishpond->name }}**.

The current temperature is **{{ $temperature }}°C**, which exceeds the safe limit.

Please take immediate action to ensure the safety of the fish.

Thank you,
**{{ config('app.name') }}**
@endcomponent
