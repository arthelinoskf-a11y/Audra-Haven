<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilitySlot extends Model
{
    protected $table = 'facility_slots';
    public $timestamps = false;

    protected $fillable = [
        'facility_id', 'name', 'start_time', 'end_time', 'quota', 'price', 'is_active',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class, 'facility_id');
    }
}