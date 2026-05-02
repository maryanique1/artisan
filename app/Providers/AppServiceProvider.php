<?php

namespace App\Providers;

use App\Events\NewNotification;
use App\Listeners\PersistNotification;
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
        Event::listen(NewNotification::class, PersistNotification::class);

        ResetPassword::createUrlUsing(function ($user, string $token) {
            $route = $user->role === 'admin' ? 'admin.password.reset' : 'password.reset';
            return url(route($route, ['token' => $token, 'email' => $user->email], false));
        });
    }
}
