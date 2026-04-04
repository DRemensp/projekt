<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scoresystem extends Model
{
    protected $fillable = [
        'is_active',
        'first_place',
        'second_place',
        'third_place',
        'max_score',
        'score_step',
        'bonus_score',
        'school_teams_override',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Gibt das aktuell aktive Scoresystem zurück
     */
    public static function getActive()
    {
        return static::where('is_active', true)->first();
    }
}
