<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Klasse extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_id',
        'name',
        'password',
        ];

    /**
     * Get the user associated with the klasse.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


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
