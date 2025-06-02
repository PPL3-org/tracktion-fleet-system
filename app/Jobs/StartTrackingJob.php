<?php

namespace App\Jobs;

use App\Models\Shipment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class StartTrackingJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $shipmentId, $lat, $lng;

    public function __construct($shipmentId, $lat, $lng)
    {
        $this->shipmentId = $shipmentId;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function handle()
    {
        $googleApiKey = config('services.google_maps.key');
        $response = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "{$this->lat},{$this->lng}",
            'key' => $googleApiKey
        ]);

        $address = $response['results'][0]['formatted_address'] ?? 'Lokasi tidak diketahui';

        $shipment = Shipment::find($this->shipmentId);
        if ($shipment) {
            $shipment->update([
                'departure_location' => $address
            ]);
        }
    }
}