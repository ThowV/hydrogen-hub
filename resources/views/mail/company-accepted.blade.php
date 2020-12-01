@component('mail::message')
# Your company has been accepted!

Here we can include a lot of talk about how cool it is that the company has been accepted.
We can also include a link to the platform as shown here:

@component('mail::button', ['url' => $url])
    Verify
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
