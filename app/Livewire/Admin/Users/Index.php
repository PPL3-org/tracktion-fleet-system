<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Index extends Component
{
    public ?User $userToDelete = null;
    public bool $showDeleteModal = false;

    protected $listeners = ['confirmUserDeletion'];

    public function confirmUserDeletion(User $user)
    {
        // Pastikan admin tidak bisa menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            // Anda bisa mengirim notifikasi/flash message di sini
            // Misalnya menggunakan $this->dispatch('toast', message: 'Anda tidak dapat menghapus akun Anda sendiri.', type: 'error');
            // atau session flash biasa jika Anda punya sistem notifikasi global
            session()->flash('lwErrorMessage', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return;
        }
        $this->userToDelete = $user;
        $this->showDeleteModal = true;
        // Jika Anda menggunakan Blade component modal yang di-dispatch event-nya
        // $this->dispatch('open-modal', name: 'deleteAdminUser'); 
    }

    public function deleteUser()
    {
        if ($this->userToDelete) {
            if ($this->userToDelete->id === Auth::id()) {
                 session()->flash('lwErrorMessage', 'Anda tidak dapat menghapus akun Anda sendiri.');
                 $this->closeDeleteModal();
                return;
            }
            $this->userToDelete->delete();
            session()->flash('lwSuccessMessage', 'Akun admin (' . $this->userToDelete->name . ') berhasil dihapus.');
            $this->closeDeleteModal();
            $this->dispatch('userDeleted')->to(Table::class); // Memberitahu table component untuk refresh
        }
    }

    public function closeDeleteModal()
    {
        $this->userToDelete = null;
        $this->showDeleteModal = false;
    }

    public function render()
    {
        // Komponen ini akan menggunakan layouts.app.blade.php secara otomatis
        // karena dirender sebagai full-page component via route.
        // Judul halaman bisa diatur di sini jika layout Anda mendukungnya
        // atau langsung di view-nya.
        return view('livewire.admin.users.index')
               ->layoutData(['title' => 'Manajemen Akun Admin']); // Jika layout Anda menggunakan $title
    }
}