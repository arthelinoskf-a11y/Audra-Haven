<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    public $timestamps = false;

    protected $fillable = [
        'category', 'name', 'description', 'price', 'image', 'is_available',
    ];

    protected $casts = [
        'price'        => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return [
            'appetizer' => 'Pembuka',
            'main'      => 'Menu Utama',
            'dessert'   => 'Penutup',
            'beverage'  => 'Minuman',
        ][$this->category] ?? $this->category;
    }
}