<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
        'order_code', 'user_id', 'reservation_id', 'room_booking_id',
        'order_type', 'total_price', 'status',
    ];

    protected $casts = ['total_price' => 'decimal:2'];

    public function user()        { return $this->belongsTo(User::class, 'user_id'); }
    public function reservation() { return $this->belongsTo(TableReservation::class, 'reservation_id'); }
    public function roomBooking() { return $this->belongsTo(RoomBooking::class, 'room_booking_id'); }
    public function items()       { return $this->hasMany(OrderItem::class, 'order_id'); }
}