<?php

namespace App\Providers;

use App\Events\NewMessageSent;
use App\Events\NewNotification;
use App\Listeners\SendFcmForMessage;
use App\Listeners\SendFcmForNotification;
use App\Services\FirebasePushService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FirebasePushService::class);
    }

    public function boot(): void
    {
        Event::listen(NewNotification::class, SendFcmForNotification::class);
        Event::listen(NewMessageSent::class, SendFcmForMessage::class);

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return url(route('admin.password.reset', ['token' => $token, 'email' => $user->email], false));
        });
    }
}
