<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'plate_number',
        'model',
        'total_distance',
        'current_status',
        'user_id' // Jika ada relasi ke user
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_distance' => 'integer',
    ];

    /**
     * Get the user that owns the truck.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shipments for the truck.
     */
    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }

    /**
     * The drivers that belong to the truck.
     */
    public function drivers()
    {
        return $this->belongsToMany(Driver::class, 'truck_driver')
            ->withTimestamps(); // Jika perlu menyimpan timestamp pivot
    }

    /**
     * Scope a query to search trucks.
     */
    public function scopeSearch($query, string $value)
    {
        return $query->where('plate_number', 'ilike', "%{$value}%")
            ->orWhere('model', 'ilike', "%{$value}%")
            ->orWhere('current_status', 'ilike', "%{$value}%");
    }
}