<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Подтверждение электронной почты')
                ->line('Нажмите на кнопку для подтверждения электорнной почты')
                ->action('Подвердить электронную почту', config('app.frontend_url') . '/confirm/register/' . $notifiable->hash);
        });
    }
}
