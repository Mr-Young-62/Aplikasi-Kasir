<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Masakan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_masakan';
    protected $fillable = [
        'nama_masakan', 
        'harga', 
        'status_masakan', 
        'foto', 
        'deskripsi', 
        'kategori'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_masakan', 'id_masakan');
    }

    public function scopeTersedia($query)
    {
        return $query->where('status_masakan', 'tersedia');
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
}
