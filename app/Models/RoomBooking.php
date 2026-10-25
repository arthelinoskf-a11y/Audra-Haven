<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    protected $table = 'room_bookings';
    public $timestamps = false;

    protected $fillable = [
        'booking_code', 'user_id', 'room_id', 'check_in', 'check_out',
        'nights', 'guests', 'subtotal', 'promo_id', 'discount_amount',
        'total_price', 'status', 'special_request', 'expires_at',
        'checked_in_at', 'checked_out_at',
    ];

    protected $casts = [
        'check_in'  => 'date',
        'check_out' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function nights()
    {
        return $this->hasMany(RoomBookingNight::class, 'room_booking_id');
    }

    public function promo()
    {
        return $this->belongsTo(Promotion::class, 'promo_id');
    }
}