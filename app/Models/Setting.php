<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'comments_enabled'
    ];

    protected $casts = [
        'comments_enabled' => 'boolean'
    ];

    /**
     * Prüft ob Kommentare aktiviert sind
     */
    public static function commentsEnabled(): bool
    {
        return Cache::remember('settings_comments_enabled', 3600, function () {
            $setting = self::first();
            return $setting ? $setting->comments_enabled : true;
        });
    }

    /**
     * Toggle Kommentar-Status
     */
    public static function toggleComments(): bool
    {
        $setting = self::firstOrCreate([]);
        $setting->comments_enabled = !$setting->comments_enabled;
        $setting->save();

        // Cache leeren
        Cache::forget('settings_comments_enabled');

        return $setting->comments_enabled;
    }
}
