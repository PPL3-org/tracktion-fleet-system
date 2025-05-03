<?php

namespace App\Livewire\Trucks;

use App\Exports\TrucksExport;
use App\Models\Truck;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class Table extends Component
{
    use WithPagination;
    protected $listeners = ['truckUpdated', 'refresh'];

    // Search filter
    #[Url(history:true)]
    public string $search = '';
    
    public $selectedTruck = [
        'id' => null,
        'plate_number' => '',
        'model' => '',
        'total_distance' => '',
        'current_status' => ''
    ];

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';
    public int $itemsPerPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function editTruckView($truckId)
    {
        $truck = Truck::findOrFail($truckId);
        $this->selectedTruck = $truck->only(['id', 'plate_number', 'model', 'total_distance', 'current_status']);
        
        $this->dispatch('open-modal', name: 'edit-truck-view');
    }

    #[On('refreshTable')] 
    public function refresh()
    {
        // Kosongkan saja, hanya untuk memicu refresh
    }
    public function updateTruck()
    {
        $this->validate([
            'selectedTruck.plate_number' => 'required|string|max:20',
            'selectedTruck.model' => 'required|string|max:255',
            'selectedTruck.total_distance' => 'required|numeric',
            'selectedTruck.current_status' => 'required|string|in:dalam pengiriman,tidak dalam pengiriman',
        ]);

        $truck = Truck::findOrFail($this->selectedTruck['id']);
        $truck->update([
            'plate_number' => $this->selectedTruck['plate_number'],
            'model' => $this->selectedTruck['model'],
            'total_distance' => $this->selectedTruck['total_distance'],
            'current_status' => $this->selectedTruck['current_status'],
        ]);

        $this->dispatch('close-modal', name: 'edit-truck-view');
        $this->dispatch('refreshTable')->self(); // Menggunakan self() karena ini component Table
        session()->flash('message', 'Data truk berhasil diperbarui.');
        
        // Reset selectedTruck
        $this->reset('selectedTruck');
    }

    public function deleteTruck($truckId)
    {
        $truck = Truck::findOrFail($truckId);
        $truck->delete();

        session()->flash('message', 'Data truk berhasil dihapus.');
        $this->resetPage();
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