@component('mail::message')
# Email change

You have requested an email change.
Please verify this change by pressing the button below.

@component('mail::button', ['url' => $route])
Verify
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
