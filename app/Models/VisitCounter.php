<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitCounter extends Model
{
    protected $table = 'visit_counters';

    protected $fillable = [
        'total_visits',
    ];
}
