<?php

namespace App\Jobs;

use App\Models\Shipment;
use App\Models\Truck;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FinishTrackingJob implements ShouldQueue
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
        $shipment = Shipment::find($this->shipmentId);
        if (!$shipment) return;

        $truck = Truck::find($shipment->truck_id);
        if (!$truck) return;

        $googleApiKey = config('services.google_maps.key');

        $reverseGeocodeResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "{$this->lat},{$this->lng}",
            'key' => $googleApiKey
        ]);
        $address = $reverseGeocodeResponse['results'][0]['formatted_address'] ?? 'Lokasi tidak diketahui';

        $distanceMatrixResponse = Http::get('https://maps.googleapis.com/maps/api/distancematrix/json', [
            'origins' => "{$shipment->departure_latitude},{$shipment->departure_longitude}",
            'destinations' => "{$this->lat},{$this->lng}",
            'key' => $googleApiKey
        ]);

        $distanceValue = $distanceMatrixResponse['rows'][0]['elements'][0]['distance']['value'] ?? 0;
        $distanceKm = round($distanceValue / 1000, 2);

        $truck->update([
            'current_status' => 'tidak dalam pengiriman',
            'total_distance' => $truck->total_distance + $distanceKm
        ]);

        $shipment->update([
            'final_location' => $address,
            'distance_traveled' => $distanceKm,
            'completed_at' => now(),
            'status' => 'selesai'
        ]);
    }
}