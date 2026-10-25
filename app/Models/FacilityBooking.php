<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityBooking extends Model
{
    protected $table = 'facility_bookings';
    public $timestamps = false;

    protected $fillable = [
        'booking_code', 'user_id', 'facility_id', 'slot_id',
        'booking_date', 'start_time', 'end_time', 'quantity',
        'total_price', 'status', 'expires_at',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price'  => 'decimal:2',
    ];

    public function user()     { return $this->belongsTo(User::class, 'user_id'); }
    public function facility() { return $this->belongsTo(Facility::class, 'facility_id'); }
    public function slot()     { return $this->belongsTo(FacilitySlot::class, 'slot_id'); }
}