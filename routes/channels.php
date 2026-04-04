<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
*/

// Lehrer-Kanal: Nur für echte Lehrer.
Broadcast::channel('admin-message.teachers', function ($user) {
    return $user->hasRole('teacher');
});

// Klassen-Kanal: Für alle Eingeloggten, die KEIN Admin und KEIN Lehrer sind.
Broadcast::channel('admin-message.klasses', function ($user) {
    return ! $user->hasRole('admin') && ! $user->hasRole('teacher');
});
