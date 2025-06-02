<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory;

    protected $appends = ['formatted_date', 'formatted_completed_at'];
    protected $fillable = [
        'user_id',
        'truck_id',
        'plate_number',
        'departure_location',
        'departure_latitude',
        'departure_longitude',
        'departure_waybill_number',
        'return_waybill_number',
        'client',
        'load_type',
        'delivery_order_price',
        'final_location',
        'completed_at',
        'distance_traveled',
        'status'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('load_type', 'ilike', "%{$value}%")
            ->orWhere('departure_waybill_number', 'ilike', "%{$value}%")
            ->orWhere('return_waybill_number', 'ilike', "%{$value}%")
            ->orWhere('client', 'ilike', "%{$value}%")
            ->orWhere('status', 'ilike', "%{$value}%")
            ->orWhere('plate_number', 'ilike', "%{$value}%");
    }


    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->translatedFormat('d F Y, H.i');
    }

    public function getFormattedCompletedAtAttribute()
    {
        Carbon::setLocale('id');
        return $this->completed_at 
            ? Carbon::parse($this->completed_at)->translatedFormat('d F Y, H.i')
            : null;
    }
}