<?php

namespace App\Livewire\Trucks;

use App\Exports\TrucksExport;
use App\Models\Truck;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

use BaconQrCode\Renderer\GDLibRenderer;
use BaconQrCode\Writer;

class Table extends Component
{
    use WithPagination;

    public $selectedTruck;

    // Search filter
    #[Url(history:true)]
    public string $search = '';

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=10;

    public function viewTruck($id)
    {
        if(empty($this->selectedTruck)) {
            $this->selectedTruck = Truck::findOrFail($id);
        }

        $this->dispatch('open-modal', name: 'view-edit-truck');
    }

    public function viewQRCode($id)
    {
        if(empty($this->selectedTruck)) {
            $this->selectedTruck = Truck::findOrFail($id);
        }

        $this->dispatch('open-modal', name: 'view-truck-qr-code');
    }

    public function viewDeleteTruck($id)
    {
        if(empty($this->selectedTruck)) {
            $this->selectedTruck = Truck::findOrFail($id);
        }

        $this->dispatch('open-modal', name: 'view-delete-truck');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function downloadTruckQRCode($id)
    {
        $truck = Truck::findOrFail($id);
        $url = route('tracking.show', $truck); 


        $renderer = new GDLibRenderer(500);

        $writer = new Writer($renderer);
        $qrImage = $writer->writeString($url);
    
        return response()->stream(function () use ($qrImage) {
            echo $qrImage;
        }, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'attachment; filename="qr-code-' . $truck->plate_number . '.png"',
        ]);
    }

    #[On('exportTruck')]
    public function export()
    {
        return Excel::download(new TrucksExport($this->search), 'truk-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        $query = Truck::search($this->search)
        ->orderBy($this->sortBy, $this->sortDir);

        return view('livewire.trucks.table', [
            'trucks' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
