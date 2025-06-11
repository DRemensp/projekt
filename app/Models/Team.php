<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'klasse_id',
        'name',
        'members',
    ];

    protected $casts = [
        'members' => 'array',
    ];

    public function klasse(){
        return $this->belongsTo(Klasse::class);
    }

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'discipline_team')
            ->withPivot(['score_1', 'score_2'])
            ->withTimestamps();
    }

}
