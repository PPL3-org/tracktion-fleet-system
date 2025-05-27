<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan Anda mengimpor model User jika belum

// Hapus atau komentari #[Title] jika modal ini akan menjadi global
// #[\Livewire\Attributes\Title('Profil Saya')] 
class Index extends Component
{
    public bool $showProfileModal = false;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?int $userId = null; // Untuk menyimpan ID user

    protected $listeners = ['openProfileModal' => 'hydrateModal'];

    public function hydrateModal(): void
    {
        $this->resetErrorBag(); // Bersihkan error validasi sebelumnya
        $user = Auth::user();
        if ($user) {
            $this->userId = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->password = ''; // Kosongkan field password setiap kali modal dibuka
            $this->password_confirmation = '';
            $this->showProfileModal = true;
        }
    }

    public function closeModal(): void
    {
        $this->showProfileModal = false;
    }

    public function updateProfile()
    {
        $user = User::find($this->userId ?? Auth::id()); // Ambil user berdasarkan ID yang disimpan atau Auth::id()

        if (!$user) {
            session()->flash('error', 'User tidak ditemukan.'); // Sebaiknya ini tidak terjadi
            $this->closeModal();
            return;
        }

        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|same:password_confirmation',
        ]);

        $user->name = $this->name;
        $user->email = $this->email;

        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        session()->flash('success', 'Profil berhasil diperbarui.');
        $this->closeModal();

        // Emit event jika Anda ingin header (nama/email) diperbarui secara dinamis tanpa refresh halaman
        $this->dispatch('profileUpdated', name: $user->name, email: $user->email); 
    }

    public function render()
    {
        return view('livewire.profile.index');
    }
}