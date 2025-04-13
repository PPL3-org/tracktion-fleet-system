<?php

namespace App\Livewire\Drivers;

use App\Models\Driver;
use Livewire\Component;
use App\Livewire\Drivers\Table;

#[\Livewire\Attributes\Title('Driver')]
class Index extends Component
{
    public string $name = '';
    public string $contact_number = '';
    public string $email = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'contact_number' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
    ];

    public function render()
    {
        return view('livewire.drivers.index');
    }

    public function addDriver()
    {
        $this->reset(['name', 'contact_number', 'email']);
        $this->dispatch('open-modal', name: 'addDriver');
    }

    public function storeDriver()
    {
        $this->validate();

        Driver::create([
            'name' => $this->name,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
        ]);

        $this->dispatch('close-modal');
        $this->dispatch('refreshTable')->to(Table::class);
        session()->flash('success', 'Pengemudi berhasil ditambahkan!');
    }

    public function exportExcel()
    {
        return $this->dispatch('exportDriver')->to(Table::class);
    }

    public $editId;
    public $isEditing = false;

    public function editDriver($id)
    {
        $this->isEditing = true;
        $this->editId = $id;

        $driver = Driver::findOrFail($id);
        $this->name = $driver->name;
        $this->contact_number = $driver->contact_number;
        $this->email = $driver->email;

        $this->dispatch('open-modal', name: 'editDriver');
    }
    public function updateDriver()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $driver = Driver::findOrFail($this->editId);
        $driver->update([
            'name' => $this->name,
            'contact_number' => $this->contact_number,
            'email' => $this->email,
        ]);

        $this->reset(['name', 'contact_number', 'email', 'editId', 'isEditing']);
        $this->dispatch('close-modal', name: 'editDriver');
        $this->dispatch('refreshTable')->to(Table::class);
        session()->flash('success', 'Data pengemudi berhasil diperbarui.');
    }
    public $deleteId;
    public $showDeleteConfirm = false;
    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->showDeleteConfirm = true;
        $this->dispatch('open-modal', name: 'deleteDriver');
    }

    public function deleteDriver()
    {
        $driver = Driver::findOrFail($this->deleteId);
        $driver->delete();

        $this->reset(['deleteId', 'showDeleteConfirm']);
        $this->dispatch('close-modal', name: 'deleteDriver');
        $this->dispatch('refreshTable')->to(Table::class);
        session()->flash('success', 'Pengemudi berhasil dihapus!');
    }
}
