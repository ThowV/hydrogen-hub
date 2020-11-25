@component('mail::message')
    # Your company has been denied!

    Unfortunately, we have decided your company does not meet the requirements.....

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
