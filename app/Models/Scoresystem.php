<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scoresystem extends Model
{
    protected $fillable = [
        'first_place',
        'second_place',
        'third_place',
        'max_score',
        'score_step',
    ];
}
