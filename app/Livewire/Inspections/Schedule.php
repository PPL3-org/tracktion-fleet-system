<?php

namespace App\Livewire\Inspections;

use App\Models\InspectionSchedule;
use App\Models\Truck;
use Livewire\Component;

#[\Livewire\Attributes\Title('Inspection Schedule')]
class Schedule extends Component
{
    public int $itemsPerPage=10;

    public $inspection_date;
    public $plate_number;

    public function render()
    {
        $query = InspectionSchedule::with('truck')->orderBy('inspection_date', 'DESC');

        return view('livewire.inspections.schedule', [
            'schedules' => $query->paginate($this->itemsPerPage),
        ]);
    }

    public function createInspectionSchedule()
    {
        $this->dispatch('open-modal', name: 'create-inspection-schedule');
    }

    public function save()
    {
        $this->plate_number = strtoupper($this->plate_number);
        $truck = Truck::where('plate_number', $this->plate_number)->first();

        if (!$truck) {
            $this->addError('plate_number', 'Nomor plat tidak ditemukan.');
            return;
        }

        InspectionSchedule::create([
            'truck_id' => $truck->id,
            'inspection_date' => $this->inspection_date,
        ]);

        $this->reset(['inspection_date', 'plate_number']);
        $this->dispatch('close-modal', name: 'create-inspection-schedule');
    }
}
