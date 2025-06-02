<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleInspection extends Model
{
    /** @use HasFactory<\Database\Factories\VehicleInspectionFactory> */
    use HasFactory;

    protected $fillable = [
        'truck_id',
        'spare_tire_available',
        'main_tire_condition',
        'tire_pressure_condition',
        'brakes_condition',
        'description',
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }
}
