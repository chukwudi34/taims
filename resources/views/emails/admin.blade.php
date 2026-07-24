@component('mail::message')
# Dear Student,

This is to inform you that a meeting is been created for your class,
so check the portal to  join live NOW
{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

Thanks,<br>
{{ config('TAIMS') }}
@endcomponent
