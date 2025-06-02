<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truck;
use App\Models\VehicleInspection;

class InspectionController extends Controller
{
    public function create(Truck $truck)
    {
        return view('inspection.create', compact('truck'));
    }

    public function createSchedule()
    {
        return view('inspection.create-schedule');
    }

    public function store(Truck $truck)
    {
        $validated = request()->validate([
            'spare_tire_available' => 'required|string',
            'main_tire_condition' => 'required|string',
            'tire_pressure_condition' => 'required|string',
            'brakes_condition' => 'required|string',
            'description' => 'string|nullable',
        ], [
            'spare_tire_available.required' => 'Mohon pilih tipe status ban cadangan.',
            'main_tire_condition.required' => 'Mohon pilih tipe status kondisi ban utama.',
            'tire_pressure_condition.required' => 'Mohon pilih tipe status kondisi tekanan angin ban utama.',
            'brakes_condition.required' => 'Mohon pilih tipe status kondisi rem kendaraan.',
        ]);

        VehicleInspection::create([
            'truck_id' => $truck->id,
            'spare_tire_available' => request()->spare_tire_available,
            'main_tire_condition' => request()->main_tire_condition,
            'tire_pressure_condition' => request()->tire_pressure_condition,
            'brakes_condition' => request()->brakes_condition,
            'description' => request()->description,
        ]);

        return redirect()->route('tracking.report-success', ['truck' => $truck->id]);
    }
}
