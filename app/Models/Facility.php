<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    protected $table = 'facilities';
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'category', 'booking_type', 'description',
        'price', 'price_unit', 'quota', 'open_time', 'close_time', 'is_active',
    ];

    protected $casts = [
        'price'     => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function photos()
    {
        return $this->hasMany(FacilityPhoto::class, 'facility_id')->orderBy('sort_order');
    }

    public function slots()
    {
        return $this->hasMany(FacilitySlot::class, 'facility_id')->orderBy('start_time');
    }

    // Helper: label kategori
    public function getCategoryLabelAttribute(): string
    {
        return [
            'tennis' => 'Lapangan Tenis',
            'gym'    => 'Fitness Center',
            'pool'   => 'Kolam Renang',
            'cabana' => 'Kabana',
        ][$this->category] ?? $this->category;
    }
}