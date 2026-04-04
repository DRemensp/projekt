<?php

namespace App\Listeners;

use App\Services\ActivityLogService;
use Illuminate\Auth\Events\Login;

class LogLoginActivity
{
    public function handle(Login $event): void
    {
        $user = $event->user;

        // Nur Teacher loggen (Admin-Logins sind irrelevant)
        if ($user->hasRole('teacher')) {
            app(ActivityLogService::class)->logLogin($user);
        }
    }
}
