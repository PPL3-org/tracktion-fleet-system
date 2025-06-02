<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'contact_number',
        'email',
    ];

    public function trucks()
    {
        return $this->belongsToMany(Truck::class, 'truck_driver');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', "%{$value}%")
            ->orWhere('contact_number', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%  {$value}%");
    }
}