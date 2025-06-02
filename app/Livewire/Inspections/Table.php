<?php

namespace App\Livewire\Inspections;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VehicleInspection;


class Table extends Component
{
    use WithPagination;

    public $selectedInspection;

    protected $listeners = ['inspectionUpdated' => '$refresh'];

    // Search filter
    #[Url(history:true)]
    public string $search = '';

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = VehicleInspection::with('truck')
        ->search($this->search)
        ->orderBy($this->sortBy, $this->sortDir);

        return view('livewire.inspections.table', [
            'inspections' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
