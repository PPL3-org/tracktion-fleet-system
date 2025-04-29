<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function show (Truck $truck)
    {
        if ($truck->current_status === 'tidak dalam pengiriman') {
            return view('tracking.show', compact('truck'));
        }

        return redirect(route('tracking.ongoing', ['truck' => $truck->id]));
    }

    public function onGoing(Truck $truck)
    {
        if($truck->current_status === 'dalam pengiriman'){
            return view('tracking.on-going', compact('truck'));
        }

        return redirect(route('tracking.show', ['truck' => $truck->id]));
    }
}