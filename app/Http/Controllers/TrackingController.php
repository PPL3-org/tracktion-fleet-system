<?php

namespace App\Http\Controllers;

use App\Jobs\ReportProcessingJob;
use App\Models\Truck;
use App\Models\Report;

class TrackingController extends Controller
{
    public function startTracking (Truck $truck)
    {
        if ($truck->current_status === 'dalam pengiriman') {
            return redirect(route('tracking.on-going', ['truck' => $truck->id]));
        }
        
        return view('tracking.start-tracking', compact('truck'));
    }

    public function onGoing(Truck $truck)
    {
        if ($truck->current_status === 'tidak dalam pengiriman'){
            return redirect(route('tracking.start-tracking', ['truck' => $truck->id]));
        }
        
        return view('tracking.on-going', compact('truck'));
    }

    public function startedSuccess(Truck $truck)
    {
        return view('tracking.start-success', compact('truck'));
    }

    public function finishSuccess(Truck $truck)
    {
        return view('tracking.finish-success', compact('truck'));
    }

    public function createReport(Truck $truck)
    {        
        if ($truck->current_status === 'tidak dalam pengiriman'){
            return redirect(route('tracking.start-tracking', ['truck' => $truck->id]));
        }

        return view('tracking.create-report', compact('truck'));
    }

    public function storeReport(Truck $truck)
    {
        $validated = request()->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'problem_type' => 'required|string',
            'problem_description' => 'string|nullable',
        ], [
            'latitude' => 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin lokasi diberikan.',
            'longitude' => 'Gagal mendapatkan lokasi. Pastikan GPS aktif dan izin lokasi diberikan.',
            'problem_type.required' => 'Mohon pilih tipe kendala.'
        ]);

        // ReportProcessingJob::dispatch($truck, $validated);

        return redirect()->route('tracking.report-success', ['truck' => $truck->id]);
    }

    public function reportSuccess(Truck $truck)
    {
        return view('tracking.report-success', compact('truck'));
    }   
}