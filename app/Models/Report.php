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
    protected $fillable = [
        'user_id',
        'shipment_id',
        'problem_type',
        'problem_description',
        'problem_location',
        'problem_latitude',
        'problem_longitude',
        'status'
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('problem_type', 'ilike', "%{$value}%")
            ->orWhere('problem_description', 'ilike', "%{$value}%")
            ->orWhereHas('shipment.truck', function($truckQuery) use ($value) {
                $truckQuery->where('plate_number', 'ilike', "%{$value}%");
            });
    }

    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->translatedFormat('d F Y, H.i');
    }
}