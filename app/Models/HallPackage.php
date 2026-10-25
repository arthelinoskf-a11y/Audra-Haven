<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallPackage extends Model
{
    protected $table = 'hall_packages';
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'base_price', 'price_per_pax', 'min_pax', 'is_active'];
}