<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testUserCanLoginSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'testing@example.com')
                    ->type('password', 'validpassword1')
                    ->press('LOG IN')
                    ->assertPathIs('/shipments');
        });
    }

    public function testUserLoginWithInvalidCredentials(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'testing@example.com')
                    ->type('password', 'invalidvalidpassword1')
                    ->press('LOG IN')
                    ->assertSee('Terdapat kesalahan pada email/password');
        });
    }

    public function testUserCanLogoutSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'testing@example.com')
                    ->type('password', 'validpassword1')
                    ->press('LOG IN')
                    ->click('@navbar')
                    ->press('Keluar')
                    ->pause(500)
                    ->assertPathIs('/login');
        });
    }
}
