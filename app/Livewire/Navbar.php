<?php

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component
{
    /**
     * Listeners untuk event.
     * 
     */
    protected $listeners = ['profileUpdated' => '$refresh'];

    public function render()
    {
        return view('livewire.navbar');
    }
}