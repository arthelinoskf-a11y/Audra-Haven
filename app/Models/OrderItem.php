<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'order_items';
    public $timestamps = false;

    protected $fillable = ['order_id', 'menu_item_id', 'quantity', 'unit_price', 'subtotal'];

    public function order() { return $this->belongsTo(Order::class, 'order_id'); }
    public function menu()  { return $this->belongsTo(MenuItem::class, 'menu_item_id'); }
}