<?php

namespace App\Livewire\Trucks;

use App\Models\Truck;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Trucks\Table;
use Illuminate\Support\Facades\Log;

#[\Livewire\Attributes\Title('Manajemen Truk')]
class Index extends Component
{
    public string $plate_number = '';
    public string $model = '';
    public string $total_distance = '0';
    public string $current_status = 'tidak dalam pengiriman';

    protected $rules = [
        'plate_number' => 'required|string|max:20|unique:trucks,plate_number',
        'model' => 'required|string|max:255',
        'total_distance' => 'required|numeric|min:0',
        'current_status' => 'required|string|in:dalam pengiriman,tidak dalam pengiriman',
    ];

    protected $messages = [
        'plate_number.required' => 'Nomor plat wajib diisi',
        'plate_number.max' => 'Nomor plat maksimal 20 karakter',
        'plate_number.unique' => 'Nomor plat sudah terdaftar',
        'model.required' => 'Model truk wajib diisi',
        'total_distance.required' => 'Jarak tempuh wajib diisi',
        'total_distance.numeric' => 'Jarak tempuh harus berupa angka',
        'total_distance.min' => 'Jarak tempuh minimal 0',
    ];

    public function render()
    {
        return view('livewire.trucks.index');
    }

    public function addTruck()
    {
        $this->resetForm();
        $this->dispatch('open-modal', name: 'add-truck');
    }

    #[On('refreshTable')]
    public function refresh()
    {
        // Method ini hanya untuk memicu refresh komponen
    }

    public function storeTruck()
    {
        $this->validate([
            'plate_number' => 'required|string',
            'model' => 'required|string',
            'total_distance' => 'nullable|string'
        ], [
            'plate_number.required' => 'Mohon isi nomor plat',
            'model.required' => 'Mohon isi model kendaraan'
        ]);

        Truck::create([
            'user_id' => Auth::id(),
            'plate_number' => strtoupper($this->plate_number),
            'model' => $this->model,
            'total_distance' => (int)$this->total_distance,
            'current_status' => $this->current_status,
        ]);

        $this->dispatch('close-modal', name: 'add-truck');
        $this->dispatch('truckUpdated');
        $this->dispatch('show-toast', 
            type: 'success',
            message: 'Data truk berhasil ditambahkan'
        );
        
        $this->resetForm();
    }

    public function exportExcel()
    {
        try {
            return $this->dispatch('exportTruck')->to(Table::class);
        } catch (\Exception $e) {
            Log::error('Gagal export data truk: ' . $e->getMessage());
            $this->dispatch('show-toast',
                type: 'error',
                message: 'Gagal melakukan export data'
            );
        }
    }

    private function resetForm()
    {
        $this->reset([
            'plate_number',
            'model',
            'total_distance',
            'current_status'
        ]);
        $this->resetErrorBag();
    }
}