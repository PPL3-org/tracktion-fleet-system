<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    /** @use HasFactory<\Database\Factories\TruckFactory> */
    use HasFactory, HasUuids;

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'truck_driver');
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('plate_number', 'like', "%{$value}%")
            ->orWhere('model', 'like', "%{$value}%")
            ->orWhere('current_status', 'like', "{$value} %");
    }
}
