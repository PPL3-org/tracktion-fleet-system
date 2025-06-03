<?php

namespace Tests\Browser;

use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManagementTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_delete_an_admin_account()
    {
        $adminSuper = User::factory()->create(['role' => 'super_admin']);
        $adminToDelete = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($adminSuper, $adminToDelete) {
            $browser->loginAs($adminSuper)
                    ->visit('/admin/users')
                    ->waitForText('Manajemen Akun Admin')
                    ->pause(1000)
                    ->press('@delete-button-' . $adminToDelete->id)
                    ->waitForText('Konfirmasi Hapus Admin')
                    ->press('Hapus')
                    ->waitForText('Akun admin')
                    ->assertSee('berhasil dihapus');
        });

        $this->assertDatabaseMissing('users', ['id' => $adminToDelete->id]);
    }

    /** @test */
    public function user_can_cancel_admin_deletion()
    {
        $adminSuper = User::factory()->create(['role' => 'super_admin']);
        $adminToKeep = User::factory()->create(['role' => 'admin']);

        $this->browse(function (Browser $browser) use ($adminSuper, $adminToKeep) {
            $browser->loginAs($adminSuper)
                    ->visit('/admin/users')
                    ->waitForText('Manajemen Akun Admin')
                    ->pause(1000)
                    ->press('@delete-button-' . $adminToKeep->id)
                    ->waitForText('Konfirmasi Hapus Admin')
                    ->press('Batal')
                    ->pause(500)
                    ->assertDontSee('Akun admin')
                    ->assertSee($adminToKeep->email);
        });

        $this->assertDatabaseHas('users', ['id' => $adminToKeep->id]);
    }
}
