<x-mail::message>
# Connection Successful!

{{ $testMessage }}

If you received this email, your SMTP configuration is working correctly.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
