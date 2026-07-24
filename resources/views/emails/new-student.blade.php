@component('mail::message')
# Dear Student,

This is to inform you that a meeting is live NOW for your class,
so check the portal immediately to join
{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('TAIMS') }}
@endcomponent
