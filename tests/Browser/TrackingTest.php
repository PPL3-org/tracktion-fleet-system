<?php

namespace Tests\Browser;

use App\Models\Truck;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TrackingTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testStartTrackingSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {

            $truck = Truck::where('current_status', 'ridak dalam pengiriman')->first();

            $browser->visit("/track/{$truck->id}")
                    ->pause(1000)
                    ->press('Mulai')
                    ->waitForLocation("/track/{$truck->id}/started-success")
                    ->assertPathEndsWith("/track/{$truck->id}/started-success");
        });
    }

    public function testUserCanVisitTrackingPage(): void
    {
        $this->browse(function (Browser $browser) {

            $truck = Truck::where('current_status', 'tidak dalam pengiriman')->first();

            $browser->visit("/track/{$truck->id}")
                    ->assertPathIs("/track/{$truck->id}");
        });
    }

    public function testFinishTrackingSuccessfully(): void
    {
        $this->browse(function (Browser $browser) {

            $truck = Truck::where('current_status', 'dalam pengiriman')->first();

            $browser->visit("/track/{$truck->id}")
                    ->pause(1000)
                    ->press('Selesai')
                    ->waitForLocation("/track/{$truck->id}/on-going/success")
                    ->assertPathEndsWith("/track/{$truck->id}/on-going/success");
        });
    }
}
