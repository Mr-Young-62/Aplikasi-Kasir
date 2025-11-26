<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'id_level',
    ];

    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_user', 'id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'id_user', 'id');
    }

    public function hasRole($role)
    {
        return $this->level && $this->level->nama_level === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole('Administrator');
    }

    public function isWaiter()
    {
        return $this->hasRole('Waiter');
    }

    public function isKasir()
    {
        return $this->hasRole('Kasir');
    }

    public function isOwner()
    {
        return $this->hasRole('Owner');
    }

    public function isPelanggan()
    {
        return $this->hasRole('Pelanggan');
    }
}
