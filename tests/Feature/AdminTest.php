<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_bisa_melihat_profil()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile.index')
            ->assertSee($user->name)
            ->assertSee($user->email);
    }
    /** @test */ 
    public function user_bisa_update_nama_dan_email()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile.index')
            ->set('name', 'Nama Baru')
            ->set('email', 'baru@example.com')
            ->call('updateProfile');

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Baru',
            'email' => 'baru@example.com',
        ]);
    }


    /** @test */

    public function user_bisa_update_password()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile.index')
            ->set('name', $user->name) // wajib diset karena divalidasi
            ->set('email', $user->email)
            ->set('password', 'passwordbaru123')
            ->set('password_confirmation', 'passwordbaru123')
            ->call('updateProfile');

        $this->assertTrue(
            Hash::check('passwordbaru123', $user->fresh()->password)
        );
    }


    /** @test */
   
    public function validasi_gagal_jika_name_atau_email_kosong()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test('profile.index')
            ->set('name', '')
            ->set('email', '')
            ->call('updateProfile')
            ->assertHasErrors(['name' => 'required', 'email' => 'required']);
    }

   
    /** @test */
    public function user_bisa_batal_edit_data_profil()
    {
        $user = User::factory()->create([
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
        ]);

        Livewire::actingAs($user)
            ->test('profile.index')
            // Modal tampil
            ->set('showProfileModal', true)
            // User ganti data dulu tapi belum disimpan
            ->set('name', 'Nama Baru')
            ->set('email', 'baru@example.com')
            // Tekan batal (panggil closeModal)
            ->call('closeModal')
            // Pastikan modal sudah tertutup
            ->assertSet('showProfileModal', false);

        // Pastikan data di database tidak berubah (tidak update)
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Nama Lama',
            'email' => 'lama@example.com',
        ]);
    }


    
}
