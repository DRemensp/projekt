<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klasse extends Model
{
    protected $fillable = [
        'school_id',
        'name',
        ];


    public function school(){
        return $this->belongsTo(School::class);
    }

    public function discipline(){
        return $this->hasOne(Discipline::class);
    }

    public function teams(){
        return $this->hasMany(Team::class);
    }

}
