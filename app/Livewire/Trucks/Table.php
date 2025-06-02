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
    public $plate_number, $model, $total_distance;

    protected $listeners = ['truckUpdated' => '$refresh'];

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
            $this->plate_number = $this->selectedTruck->plate_number;
            $this->model = $this->selectedTruck->model;
            $this->total_distance = $this->selectedTruck->total_distance;
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

    public function updateTruck()
    {
        $this->validate([
            'plate_number' => 'required|string',
            'model' => 'required|string',
            'total_distance' => 'required'
        ], [
            'plate_number.required' => 'Plat nomor tidak boleh kosong',
            'model.required' => 'Model kendaraan tidak boleh kosong.'
        ]);

        $truck = Truck::findOrFail($this->selectedTruck->id);

        $truck->update([
            'plate_number' => $this->plate_number,
            'model' => $this->model,
            'total_distance' => $this->total_distance,
        ]);

        $this->dispatch('close-modal', name: 'edit-truck-view');
        $this->dispatch('truckUpdated');
        $this->dispatch('show-toast', 
            type: 'success',
            message: 'Data truk berhasil diperbarui'
        );
        
        $this->reset('selectedTruck');
    }

    public function deleteTruck()
    {
        $truck = Truck::findOrFail($this->selectedTruck->id);

        $truck->delete();

        $this->dispatch('close-modal');
        $this->dispatch('truckUpdated');
        $this->dispatch('show-toast', 
            type: 'success',
            message: 'Data truk berhasil dihapus'
        );

        $this->reset('selectedTruck');
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
