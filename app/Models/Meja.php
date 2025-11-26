<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_meja';
    protected $fillable = [
        'no_meja', 
        'status_meja', 
        'kapasitas', 
        'lokasi'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'no_meja', 'no_meja');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status_meja', 'kosong');
    }

    public function scopeTerisi($query)
    {
        return $query->where('status_meja', 'terisi');
    }
}
