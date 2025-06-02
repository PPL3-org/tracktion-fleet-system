<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function scopeSearch($query, $value)
    {
        return $query->where('spare_tire_available', 'ilike', "%{$value}%")
            ->orWhere('main_tire_condition', 'ilike', "%{$value}%")
            ->orWhere('tire_pressure_condition', 'ilike', "%{$value}%")
            ->orWhere('brakes_condition', 'ilike', "%{$value}%")
            ->orWhere('description', 'ilike', "%{$value}%")
            ->orWhereHas('truck', function($truckQuery) use ($value) {
                $truckQuery->where('plate_number', 'ilike', "%{$value}%");
            });
    }

    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->translatedFormat('d F Y, H.i');
    }
}
