<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $appends = ['formatted_date'];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('problem_type', 'like', "%{$value}%")
            ->orWhere('problem_description', 'like', "%{$value}%")
            ->orWhereHas('shipment.truck', function($truckQuery) use ($value) {
                $truckQuery->where('plate_number', 'like', "%{$value}%");
            });
    }

    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->translatedFormat('d F Y, H.i');
    }
}
