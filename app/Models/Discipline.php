<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    protected $fillable = [
        'klasse_id',
        'name',
        'max_score',
        'score_step',
        'description',
        'higher_is_better'
    ];



    public function klasse(){
        return $this->belongsTo(Klasse::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'discipline_team')
            ->withPivot(['score_1', 'score_2'])
            ->withTimestamps();
    }

}
