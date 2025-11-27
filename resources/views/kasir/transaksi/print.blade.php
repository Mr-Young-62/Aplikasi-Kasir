<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran #{{ $transaksi->id_transaksi }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
            padding: 20px;
        }
        
        .struk-container {
            max-width: 400px;
            margin: 0 auto;
            background: white;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px dashed #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 10px;
            color: #666;
        }
        
        .transaction-info {
            margin-bottom: 20px;
        }
        
        .transaction-info .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .transaction-info .label {
            font-weight: bold;
        }
        
        .items-table {
            margin-bottom: 20px;
            border-bottom: 1px dashed #333;
            padding-bottom: 15px;
        }
        
        .items-table .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .items-table .item-name {
            flex: 1;
        }
        
        .items-table .item-details {
            font-size: 10px;
            color: #666;
            margin-left: 10px;
        }
        
        .items-table .item-price {
            text-align: right;
            min-width: 80px;
        }
        
        .summary {
            margin-bottom: 20px;
        }
        
        .summary .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .summary .total {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px dashed #333;
            padding-top: 5px;
            margin-top: 10px;
        }
        
        .payment-info {
            margin-bottom: 20px;
            border-bottom: 1px dashed #333;
            padding-bottom: 15px;
        }
        
        .payment-info .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #333;
        }
        
        .footer p {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        
        .status-berhasil {
            color: #16a34a;
            font-weight: bold;
        }
        
        .status-batal {
            color: #dc2626;
            font-weight: bold;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .struk-container {
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <!-- Header -->
        <div class="header">
            <h1>RESTO POS</h1>
            <p>Jl. Contoh No. 123, Jakarta</p>
            <p>Telp: (021) 123-4567</p>
        </div>

        <!-- Transaction Info -->
        <div class="transaction-info">
            <div class="row">
                <span class="label">No. Transaksi:</span>
                <span>#{{ $transaksi->id_transaksi }}</span>
            </div>
            <div class="row">
                <span class="label">Tanggal:</span>
                <span>{{ $transaksi->tanggal->format('d/m/Y H:i') }}</span>
            </div>
            <div class="row">
                <span class="label">Kasir:</span>
                <span>{{ $transaksi->user->name }}</span>
            </div>
            <div class="row">
                <span class="label">Meja:</span>
                <span>Meja {{ $transaksi->order->meja->nomor_meja }}</span>
            </div>
            <div class="row">
                <span class="label">Order ID:</span>
                <span>#{{ $transaksi->order->id_order }}</span>
            </div>
        </div>

        <!-- Items -->
        <div class="items-table">
            @foreach($transaksi->order->detailOrders as $detail)
                <div class="item">
                    <div class="item-name">
                        {{ $detail->masakan->nama_masakan }}
                        <div class="item-details">{{ $detail->jumlah }} x Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}</div>
                        @if($detail->keterangan)
                            <div class="item-details">{{ $detail->keterangan }}</div>
                        @endif
                    </div>
                    <div class="item-price">
                        Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="summary">
            <div class="row">
                <span>Subtotal:</span>
                <span>Rp. {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="row">
                <span>PPN (10%):</span>
                <span>Rp. {{ number_format($transaksi->total_bayar * 0.1, 0, ',', '.') }}</span>
            </div>
            <div class="row total">
                <span>TOTAL:</span>
                <span>Rp. {{ number_format($transaksi->total_bayar * 1.1, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Info -->
        <div class="payment-info">
            <div class="row">
                <span class="label">Metode Bayar:</span>
                <span>
                    @switch($transaksi->metode_pembayaran)
                        @case('cash')
                            Cash
                            @break
                        @case('transfer')
                            Transfer
                            @break
                        @case('kartu')
                            Kartu
                            @break
                        @case('ewallet')
                            E-Wallet
                            @break
                    @endswitch
                </span>
            </div>
            <div class="row">
                <span class="label">Uang Bayar:</span>
                <span>Rp. {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
            </div>
            @if($transaksi->kembalian > 0)
                <div class="row">
                    <span class="label">Kembalian:</span>
                    <span>Rp. {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                </div>
            @endif
            @if($transaksi->no_referensi)
                <div class="row">
                    <span class="label">No. Referensi:</span>
                    <span>{{ $transaksi->no_referensi }}</span>
                </div>
            @endif
            <div class="row">
                <span class="label">Status:</span>
                <span class="{{ $transaksi->status_transaksi === 'berhasil' ? 'status-berhasil' : 'status-batal' }}">
                    {{ ucfirst($transaksi->status_transaksi) }}
                </span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih atas kunjungan Anda</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            <p>{{ now()->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            window.print();
            // Close window after printing (optional)
            setTimeout(function() {
                window.close();
            }, 1000);
        };
    </script>
</body>
</html>
