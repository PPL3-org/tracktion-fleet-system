<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegistrationTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testUserCanRegisterSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'testing user', 200)
                    ->type('email', 'testing@example.com', 200)
                    ->type('password', 'validpassword1', 200)
                    ->type('password_confirmation', 'validpassword1', 200)
                    ->press('Register')
                    ->assertPathIs('/shipments');
        });
    }

    public function testUserRegisterWithExistingAccount(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'testing user', 200)
                    ->type('email', 'testing@example.com', 200)
                    ->type('password', 'validpassword1', 200)
                    ->type('password_confirmation', 'validpassword1', 200)
                    ->press('Register')
                    ->assertSee('Email sudah terdaftar');
        });
    }

    public function testUserRegisterWithWrongConfirmationPassword(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'testing user', 200)
                    ->type('email', 'testingnew@example.com', 200)
                    ->type('password', 'validpassword1', 200)
                    ->type('password_confirmation', 'invalidpassword1', 200)
                    ->press('Register')
                    ->assertSee('Konfirmasi kata sandi tidak sesuai');
        });
    }
}
