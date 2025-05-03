<?php

namespace App\Jobs;

use App\Models\Report;
use App\Models\Truck;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ReportProcessingJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected Truck $truck;
    protected $validatedRequest;

    /**
     * Create a new job instance.
     */
    public function __construct(Truck $truck, array $validatedRequest)
    {
        $this->truck = $truck;
        $this->validatedRequest = $validatedRequest;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Find location
        $googleApiKey = config('services.google_maps.key');

        $reverseGeocodeResponse = Http::get('https://maps.googleapis.com/maps/api/geocode/json', [
            'latlng' => "{$this->validatedRequest['latitude']},{$this->validatedRequest['longitude']}",
            'key' => $googleApiKey
        ]);
        $address = $reverseGeocodeResponse['results'][0]['formatted_address'] ?? 'Lokasi tidak diketahui';

        // Create truck instance
        Report::create([
            'user_id' => $this->truck->user_id,
            'truck_id' => $this->truck->id,
            'plate_number' => $this->truck->plate_number,
            'report_location' => $address,
            'problem_type' => $this->validatedRequest['problem_type'],
            'problem_description' => $this->validatedRequest['problem_description']
        ]);
    }
}
