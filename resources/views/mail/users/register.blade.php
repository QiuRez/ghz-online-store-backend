<x-mail::message>
# Вы успешно зарегистрированы в нашей системе!

Пожалуйста, введите код из блока ниже на странице сайта для подтверждения почты

<x-mail::panel>
<h1 style="text-align: center; font-size: 40px; margin-top: revert;">{{ $code }}</h1>
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
