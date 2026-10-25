<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomBookingNight extends Model
{
    protected $table = 'room_booking_nights';
    public $timestamps = false;

    protected $fillable = [
        'room_booking_id', 'stay_date', 'base_price',
        'markup_percent', 'price', 'rule_name',
    ];
}