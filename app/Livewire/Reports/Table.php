<?php

namespace App\Livewire\Reports;

use App\Exports\ReportsExport;
use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Support\Facades\Auth;

class Table extends Component
{
    use WithPagination;

    public $selectedReport;

    // Search filter
    #[Url(history:true)]
    public string $search = '';

    // Date filter
    #[Url(history:true)]
    public $startDate = '';
    #[Url(history:true)]
    public $endDate = '';

    public string $sortBy = 'created_at';
    public string $sortDir = 'DESC';

    // number of items per page
    public int $itemsPerPage=10;

    public function viewReport($id)
    {
        $this->selectedReport = Report::findOrFail($id);

        $this->dispatch('open-modal', name: 'detail-view-report');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    #[On('exportReport')]
    public function export()
    {
        return Excel::download(new ReportsExport($this->search, $this->startDate, $this->endDate), 'laporan-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        $query = Report::where('user_id', Auth::user()->id)
            ->search($this->search)
            ->orderBy($this->sortBy, $this->sortDir);

        if (!empty($this->startDate) && !empty($this->endDate)) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return view('livewire.reports.table', [
            'reports' => $query->paginate($this->itemsPerPage),
        ]);
    }
}
