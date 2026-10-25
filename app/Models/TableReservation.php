<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableReservation extends Model
{
    protected $table = 'table_reservations';
    public $timestamps = false;

    protected $fillable = [
        'booking_code', 'user_id', 'table_id', 'reservation_date',
        'start_time', 'end_time', 'guests', 'notes', 'status',
    ];

    protected $casts = ['reservation_date' => 'date'];

    public function user()  { return $this->belongsTo(User::class, 'user_id'); }
    public function table() { return $this->belongsTo(RestaurantTable::class, 'table_id'); }
}