<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_meja';
    protected $fillable = [
        'nomor_meja', 
        'status_meja', 
        'kapasitas', 
        'lokasi',
        'deskripsi',
        'qr_code'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'id_meja', 'id_meja');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status_meja', 'tersedia');
    }

    public function scopeTerisi($query)
    {
        return $query->where('status_meja', 'terisi');
    }

    public function scopeDipesan($query)
    {
        return $query->where('status_meja', 'dipesan');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status_meja', 'maintenance');
    }
}
