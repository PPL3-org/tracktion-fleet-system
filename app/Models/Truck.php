<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    /** @use HasFactory<\Database\Factories\TruckFactory> */
    use HasFactory, HasUuids;
    protected $primaryKey = 'id';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = ['user_id', 'plate_number', 'model', 'current_status', 'total_distance'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vehicleInspections()
    {
        return $this->hasMany(VehicleInspection::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'truck_driver');
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('plate_number', 'ilike', "%{$value}%")
            ->orWhere('model', 'ilike', "%{$value}%")
            ->orWhere('current_status', 'ilike', "{$value} %");
    }
}
