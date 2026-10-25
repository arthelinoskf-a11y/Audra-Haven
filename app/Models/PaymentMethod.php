<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    // Beri tahu Laravel kalau tabelnya bernama 'payment_methods'
    protected $table = 'payment_methods';

    // Matikan timestamps karena di tabel SQL-mu tidak ada created_at/updated_at
    public $timestamps = false;

    // Izinkan semua kolom diisi (mass assignment)
    protected $guarded = [];
}