<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    public $timestamps = false;

    protected $fillable = ['room_type_id', 'room_number', 'floor', 'status'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}