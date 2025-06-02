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
        'truck_id',
        'plate_number',
        'report_location',
        'problem_type',
        'problem_description',
        'status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('problem_type', 'ilike', "%{$value}%")
            ->orWhere('problem_description', 'ilike', "%{$value}%")
            ->orWhere('report_location', 'ilike', "%{$value}%")
            ->orWhere('plate_number', 'ilike', "%{$value}%");
    }

    public function getFormattedDateAttribute()
    {
        Carbon::setLocale('id');
        return Carbon::parse($this->created_at)->translatedFormat('d F Y, H.i');
    }
    // komang
}