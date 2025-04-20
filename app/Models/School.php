<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
    ];

    public function klasses(){
        return $this->hasMany(Klasse::class);
    }
}



/*use App\Models\School;
erstellen von den Schulen
// 1. Ferdinand-von-Steinbeis-Schule
School::create([
    'name' => 'Ferdinand-von-Steinbeis-Schule'
]);

// 2. Laura-Schradin-Schule
School::create([
    'name' => 'Laura-Schradin-Schule'
]);

// 3. Kerschensteinerschule
School::create([
    'name' => 'Kerschensteinerschule'
]);

// 4. Reutlingen Fachschule Für Wirtschaft
School::create([
    'name' => 'Reutlingen Fachschule Für Wirtschaft'
]); */
