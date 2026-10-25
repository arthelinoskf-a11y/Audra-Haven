<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallBooking extends Model
{
    protected $table = 'hall_bookings';
    public $timestamps = false;

    protected $fillable = [
        'booking_code', 'user_id', 'hall_id', 'package_id', 'event_name',
        'event_date', 'session', 'pax', 'hall_price', 'package_price',
        'addons_total', 'promo_id', 'discount_amount', 'total_price',
        'dp_amount', 'status', 'notes', 'expires_at',
    ];

    protected $casts = [
        'event_date'  => 'date',
        'total_price' => 'decimal:2',
    ];

    public function user()    { return $this->belongsTo(User::class, 'user_id'); }
    public function hall()    { return $this->belongsTo(Hall::class, 'hall_id'); }
    public function package() { return $this->belongsTo(HallPackage::class, 'package_id'); }
}