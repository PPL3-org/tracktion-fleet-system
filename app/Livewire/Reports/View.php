<?php

namespace App\Livewire\Reports;

use Livewire\Component;

class View extends Component
{
    public $report;

    public function mount($report)
    {
        $this->report = $report;
    }
    
    public function render()
    {
        return view('livewire.reports.view');
    }
}
