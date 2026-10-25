<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'room_types';
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'description', 'base_price', 'capacity',
        'size_m2', 'bed_type', 'amenities', 'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'is_active'  => 'boolean',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}