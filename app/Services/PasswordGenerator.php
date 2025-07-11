<?php

namespace App\Services;

class PasswordGenerator
{

    protected $words = [
        'Hand', 'Kuss', 'Baum', 'Haus', 'Auto', 'Tisch', 'Stuhl', 'Buch', 'Stift', 'Lampe',
        'Hund', 'Fenster', 'Wand', 'Boden', 'Decke', 'Garten', 'Blume', 'Sonne', 'Mond', 'Stern',
        'Wasser', 'Feuer', 'Erde', 'Luft', 'Berg', 'Tal', 'Fluss', 'See', 'Meer', 'Wald',
        'Wiese', 'Feld', 'Pferd', 'Weg', 'Teller', 'Stadt', 'Dorf', 'Land', 'Himmel', 'Wolke',
        'Regen', 'Schnee', 'Wind', 'Sturm', 'Blitz', 'Donner', 'Tag', 'Nacht', 'Morgen', 'Abend'
    ];


    public function generate(): string
    {
        $password = '';
        $wordCount = count($this->words);

        // Select 3 random words
        for ($i = 0; $i < 3; $i++) {
            $randomIndex = rand(0, $wordCount - 1);
            $password .= $this->words[$randomIndex];
        }

        return $password;
    }
}
