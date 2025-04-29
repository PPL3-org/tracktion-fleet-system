<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Jobs\FinishTrackingJob;
use App\Jobs\StartTrackingJob;

class LocationController extends Controller
{
    public function startTracking(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'truck_id' => 'required'
        ]);

        $lat = $request->latitude;
        $lng = $request->longitude;
        $truck = Truck::findOrFail($request->truck_id);

        // Update status early
        $truck->update([
            'current_status' => 'dalam pengiriman'
        ]);

        // Create shipment with placeholder address
        $shipment = Shipment::create([
            'user_id' => $truck->user_id,
            'truck_id' => $truck->id,
            'plate_number' => $truck->plate_number,
            'departure_latitude' => $lat,
            'departure_longitude' => $lng,
            'departure_location' => 'Sedang memuat lokasi...',
            'status' => 'perjalanan'
        ]);

        // Dispatch background job to reverse geocode
        StartTrackingJob::dispatch($shipment->id, $lat, $lng);

        return response([
            'Message' => 'Tracking started successfully'
        ], 200)->header('Content-Type', 'application/json');
    }

    public function finishTracking(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'truck_id' => 'required'
        ]);

        $truck = Truck::findOrFail($request->truck_id);
        $shipment = Shipment::where('truck_id', $truck->id)
                            ->latest()
                            ->firstOrFail();

        // Dispatch async job to calculate distance and complete shipment
        FinishTrackingJob::dispatch($shipment->id, $request->latitude, $request->longitude);

        return response([
            'Message' => 'Tracking completed. Processing in background.'
        ], 200)->header('Content-Type', 'application/json');
    }
}
