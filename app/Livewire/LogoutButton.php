<?php

namespace App\Livewire;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class LogoutButton extends Component
{
    public function logout(Logout $logoutAction)
    {
        $logoutAction(); // Ruft die __invoke-Methode der Action auf weil Laravel absolut weird ist
        return redirect('/')->with('success', 'You are logged out.');
    }

    public function render()
    {
        return view('livewire.logout-button');
    }
}

