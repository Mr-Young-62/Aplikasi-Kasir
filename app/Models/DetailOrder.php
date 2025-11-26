<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_detail_order';
    protected $fillable = [
        'id_order',
        'id_masakan',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'keterangan',
        'status_detail_order'
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }

    public function masakan()
    {
        return $this->belongsTo(Masakan::class, 'id_masakan', 'id_masakan');
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($detailOrder) {
            $detailOrder->subtotal = $detailOrder->jumlah * $detailOrder->harga_satuan;
        });

        static::saved(function ($detailOrder) {
            $detailOrder->order->calculateTotal();
        });

        static::deleted(function ($detailOrder) {
            $detailOrder->order->calculateTotal();
        });
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status_detail_order', $status);
    }
}
