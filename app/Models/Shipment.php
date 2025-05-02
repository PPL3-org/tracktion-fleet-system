<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentFactory> */
    use HasFactory;

    protected $appends = ['formatted_date'];
    protected $fillable = [
        'departure_waybill_number',
        'return_waybill_number',
        'client',
        'load_type',
        'delivery_order_price'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('load_type', 'like', "%{$value}%")
            ->orWhere('departure_waybill_number', 'like', "%{$value}%")
            ->orWhere('return_waybill_number', 'like', "%{$value}%")
            ->orWhere('client', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%")
            ->orWhereHas('truck', function ($query) use ($value) {
                $query->where('plate_number', 'like', "%{$value}%");
            });
    }


    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->translatedFormat('d F Y, H.i');
    }
}
