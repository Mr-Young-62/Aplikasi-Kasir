<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_user',
        'id_order',
        'tanggal',
        'total_bayar',
        'uang_bayar',
        'kembalian',
        'metode_pembayaran',
        'no_referensi',
        'status_transaksi'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_bayar' => 'decimal:2',
        'uang_bayar' => 'decimal:2',
        'kembalian' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaksi) {
            $transaksi->kembalian = $transaksi->uang_bayar - $transaksi->total_bayar;
        });

        static::saved(function ($transaksi) {
            if ($transaksi->status_transaksi === 'berhasil') {
                $transaksi->order->update(['status_order' => 'dibayar']);
            }
        });
    }

    public function scopeByTanggal($query, $tanggal)
    {
        return $query->whereDate('tanggal', $tanggal);
    }

    public function scopeByPeriode($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }

    public function scopeBerhasil($query)
    {
        return $query->where('status_transaksi', 'berhasil');
    }
}
