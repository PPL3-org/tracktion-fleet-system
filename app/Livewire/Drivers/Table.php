<?php  

namespace App\Livewire\Drivers;  

use App\Exports\DriversExport;  
use App\Models\Driver;  
use Livewire\Attributes\Url;  
use Livewire\Attributes\On;  
use Livewire\Component;  
use Livewire\WithPagination;  
use Maatwebsite\Excel\Facades\Excel;  

#[On('exportDriver')]  
#[On('refreshTable')]  
#[On('confirmDelete')]  // listen event konfirmasi hapus  
class Table extends Component  
{  
    use WithPagination;  

    #[Url(history: true)]  
    public string $search = '';  

    public string $sortBy = 'created_at';  
    public string $sortDir = 'DESC';  

    public $selectedDriver = [  
        'id' => null,  
        'name' => '',  
        'contact_number' => '',  
        'email' => '',  
    ];  

    public int $itemsPerPage = 5;  

    public function updatedSearch()  
    {  
        $this->resetPage();  
    }  

    public function editViewDriver($driverId)  
    {  
        $driver = Driver::findOrFail($driverId);  
        $this->selectedDriver = $driver->only(['id', 'name', 'contact_number', 'email']);  

        $this->dispatch('open-modal', name: 'edit-driver-view');  
    }  

    public function updateDriver()  
    {   
        $this->validate([  
            'selectedDriver.name' => 'required|string',  
            'selectedDriver.contact_number' => 'required|string',  
            'selectedDriver.email' => 'required|email',  
        ]);  

        $driver = Driver::findOrFail($this->selectedDriver['id']);  
        $driver->update([  
            'name' => $this->selectedDriver['name'],  
            'contact_number' => $this->selectedDriver['contact_number'],  
            'email' => $this->selectedDriver['email'],  
        ]);  

        $this->dispatch('closeModal', 'edit-driver-view');  
        session()->flash('message', 'Data pengemudi berhasil diperbarui.');  
    }  

    // Tambahan fitur delete  
    public function deleteDriver($driverId)  
    {  
        $driver = Driver::findOrFail($driverId);  
        $driver->delete();  

        session()->flash('message', 'Data pengemudi berhasil dihapus.');  
        $this->resetPage(); // agar redirect ke halaman yang sesuai setelah hapus  
    }  

    public function export()  
    {  
        return Excel::download(new DriversExport($this->search), 'pengemudi-' . now()->format('Y-m-d') . '.xlsx');  
    }  

    public function render()  
    {  
        $query = Driver::search($this->search)  
            ->orderBy($this->sortBy, $this->sortDir);  

        return view('livewire.drivers.table', [  
            'drivers' => $query->paginate($this->itemsPerPage),  
        ]);  
    }  
}  