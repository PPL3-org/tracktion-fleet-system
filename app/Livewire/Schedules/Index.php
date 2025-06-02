<?php

namespace App\Livewire\Schedules;

use App\Models\ShipmentSchedule;
use Livewire\Component;

class Index extends Component
{
    public $delivery_price, $departure_date, $client;

    public function render()
    {
        return view('livewire.schedules.index');
    }

    public function addShipmentSchedule()
    {
        $this->dispatch('open-modal', name: 'create-shipment-schedule');
    }

    public function save()
    {
        ShipmentSchedule::create([
            'client' => $this->client,
            'delivery_price' => $this->delivery_price,
            'departure_date' => $this->departure_date,
        ]);

        $this->reset(['delivery_price', 'client', 'departure_date']);
        $this->dispatch('close-modal', name: 'create-shipment-schedule');
        $this->dispatch('shipmentScheduleUpdated');
    }
}