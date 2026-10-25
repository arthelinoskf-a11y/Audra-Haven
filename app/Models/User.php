<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';

    // ✅ Tambahkan baris ini
    public $timestamps = false;

    protected $fillable = [
        'role_id',
        'full_name',
        'email',
        'phone',
        'password',
        'is_active',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_active' => 'boolean',
        'password'  => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    public function isAdmin(): bool
    {
        return $this->role && $this->role->name === 'admin';
    }
}