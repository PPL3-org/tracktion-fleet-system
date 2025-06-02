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
    public $problem_type;
    public $problem_description;

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

    public function viewEditReport($id)
    {
        if(empty($this->selectedReport)) {
            $this->selectedReport = Report::findOrFail($id);
            $this->problem_type = $this->selectedReport->problem_type;
            $this->problem_description = $this->selectedReport->problem_description;
        }

        $this->dispatch('open-modal', name: 'view-edit-report');
    }

    public function updateReport()
    {
        $this->validate([
            'problem_type' => 'required|string',
            'problem_description' => 'required|string',
        ]);

        $report = Report::findOrFail($this->selectedReport->id);

        $report->update([
            'problem_type' => $this->problem_type,
            'problem_description' => $this->problem_description,
        ]);

        $this->dispatch('reportUpdated')->to(Table::class);
        $this->dispatch('close-modal');
    }

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
