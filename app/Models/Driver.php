<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_number',
        'email',
    ];

    public function trucks()
    {
        return $this->belongsToMany(Truck::class, 'truck_driver');
    }
    # Searchable fields
    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'ilike', "%{$value}%")
            ->orWhere('contact_number', 'ilike', "%{$value}%")
            ->orWhere('email', 'ilike', "%{$value}%");
    }
}
