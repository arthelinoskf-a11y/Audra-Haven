<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    protected $table = 'halls';
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'description', 'capacity', 'size_m2',
        'price_per_session', 'full_day_price', 'is_active',
    ];

    protected $casts = [
        'price_per_session' => 'decimal:2',
        'full_day_price'    => 'decimal:2',
        'is_active'         => 'boolean',
    ];

    public function photos()
    {
        return $this->hasMany(HallPhoto::class, 'hall_id')->orderBy('sort_order');
    }

    public function bookings()
    {
        return $this->hasMany(HallBooking::class, 'hall_id');
    }
}