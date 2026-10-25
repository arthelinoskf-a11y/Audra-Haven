<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallPhoto extends Model
{
    protected $table = 'hall_photos';
    public $timestamps = false;

    protected $fillable = ['hall_id', 'file_name', 'is_cover', 'sort_order'];

    public function hall()
    {
        return $this->belongsTo(Hall::class, 'hall_id');
    }
}