<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentSchedule extends Model
{
    /** @use HasFactory<\Database\Factories\ShipmentScheduleFactory> */
    use HasFactory;

    protected $fillable = [
        'client',
        'delivery_price',
        'departure_date'
    ];
}
