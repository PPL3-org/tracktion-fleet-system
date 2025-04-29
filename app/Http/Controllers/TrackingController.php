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
}