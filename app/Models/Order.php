<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_order';
    protected $fillable = [
        'no_meja',
        'tanggal',
        'id_user',
        'keterangan',
        'status_order',
        'total_harga'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_harga' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function meja()
    {
        return $this->belongsTo(Meja::class, 'no_meja', 'nomor_meja');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_order', 'id_order');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'id_order', 'id_order');
    }

    public function calculateTotal()
    {
        $total = $this->detailOrders()->sum('subtotal');
        $this->update(['total_harga' => $total]);
        return $total;
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_order', $status);
    }

    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }
}
