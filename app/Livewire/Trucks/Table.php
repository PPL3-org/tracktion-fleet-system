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

    // Search filter
    #[Url(history:true)]
    public string $search = '';
    public $selectedTruck;

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function editTruckView($truckId)
    {
        $this->selectedTruck = Truck::where('id', $truckId)->first();

        $this->dispatch('open-modal', name: 'edit-view-truck');
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
