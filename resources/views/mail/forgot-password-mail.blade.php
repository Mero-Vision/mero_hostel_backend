<x-mail::message>
# Mero Hostel

Hi there,

You have requested to reset your password. Click the button below to reset your password:

<x-mail::button :url="$url">
Reset Password
</x-mail::button>

If you did not request a password reset, please ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
