<?php

namespace App\Livewire\Schedules;

use App\Models\ShipmentSchedule;
use Livewire\Component;

class Tables extends Component
{
    public $selectedSchedule, $delivery_price, $client, $departure_date;
    public $itemsPerPage;
    protected $listeners = ['shipmentScheduleUpdated' => '$refresh'];

    public function viewEditSchedule($id)
    {
        if(empty($this->selectedShedule)) {
            $this->selectedSchedule = ShipmentSchedule::findOrFail($id);
            $this->client = $this->selectedSchedule->client;
            $this->delivery_price = $this->selectedSchedule->delivery_price;
            $this->departure_date = $this->selectedSchedule->departure_date;
        }

        $this->dispatch('open-modal', name: 'view-edit-shipment-schedule');
    }

    public function viewDeleteShipmentSchedule($id)
    {
        if(empty($this->selectedShedule)) {
            $this->selectedSchedule = ShipmentSchedule::findOrFail($id);
            $this->client = $this->selectedSchedule->client;
            $this->delivery_price = $this->selectedSchedule->delivery_price;
            $this->departure_date = $this->selectedSchedule->departure_date;

        }

        $this->dispatch('open-modal', name: 'view-delete-shipment-schedule');
    }

    public function deleteSchedule()
    {
        $schedule = ShipmentSchedule::find($this->selectedSchedule->id);

        $schedule->delete();

        $this->reset(['selectedSchedule', 'delivery_price', 'client', 'departure_date']);

        $this->dispatch('shipmentScheduleUpdated');
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $query = ShipmentSchedule::orderBy('departure_date', 'DESC');

        return view('livewire.schedules.tables', [
            'schedules' => $query->paginate($this->itemsPerPage),
        ]);
    }

    public function updateSchedule()
    {
        
        $this->validate([
            'client' => 'required|string',
            'delivery_price' => 'required|numeric',
        ]);

        $schedule = ShipmentSchedule::findOrFail($this->selectedSchedule->id);

        $schedule->update([
            'client' => $this->client,
            'delivery_price' => $this->delivery_price,
            'departure_date' => $this->departure_date,
        ]);

        $this->dispatch('shipmentScheduleUpdated');
        $this->dispatch('close-modal');
        $this->reset(['selectedSchedule', 'delivery_price', 'client', 'departure_date']);
    }
}
