<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
    public $timestamps = false;

    protected $fillable = [
        'code', 'title', 'description', 'applies_to',
        'discount_percent', 'max_discount', 'min_amount',
        'start_date', 'end_date', 'quota', 'used_count', 'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'is_active'  => 'boolean',
    ];
}