<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('admin-message.teachers', function ($user) {
    return $user->hasRole('teacher');
});

Broadcast::channel('admin-message.klasses', function ($user) {
    return ! $user->hasRole('admin') && ! $user->hasRole('teacher');
});
