<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantTable extends Model
{
    protected $table = 'restaurant_tables';
    public $timestamps = false;

    protected $fillable = ['table_number', 'capacity', 'area', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];
}