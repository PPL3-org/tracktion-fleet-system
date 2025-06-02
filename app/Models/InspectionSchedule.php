<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InspectionSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'truck_id',
        'inspection_date'
    ];

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }

    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->inspection_date)->translatedFormat('d F Y, H.i');
    }
}
