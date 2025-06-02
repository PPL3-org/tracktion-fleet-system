<?php

namespace App\Livewire\Inspections;

use Livewire\Component;

#[\Livewire\Attributes\Title('Inspection')]

class Index extends Component
{
    public function render()
    {
        return view('livewire.inspections.index');
    }

    public function addInspectionSchedule()
    {
        return redirect(route('inspections.schedule'));
    }
}
