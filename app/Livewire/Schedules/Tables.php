<?php

namespace App\Livewire\Schedules;

use App\Models\ShipmentSchedule;
use Livewire\Component;

class Tables extends Component
{
    public $itemsPerPage;
    protected $listeners = ['shipmentScheduleUpdated' => '$refresh'];
    public function render()
    {
        $query = ShipmentSchedule::orderBy('departure_date', 'DESC');

        return view('livewire.schedules.tables', [
            'schedules' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
