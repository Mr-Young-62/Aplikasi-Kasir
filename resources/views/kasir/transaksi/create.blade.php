@extends('layouts.app')

@section('title', 'Buat Transaksi')
@section('header', 'Buat Transaksi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-2">
            <a href="{{ route('kasir.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <i class="fas fa-chevron-right"></i>
            <span class="text-gray-900">Buat Transaksi</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Transaksi</h1>
        <p class="text-gray-600">Proses pembayaran untuk Order #{{ $order->id_order }}</p>
    </div>

    <!-- Order Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-blue-600">Order ID</p>
                <p class="font-medium text-blue-900">#{{ $order->id_order }}</p>
            </div>
            <div>
                <p class="text-sm text-blue-600">Meja</p>
                <p class="font-medium text-blue-900">Meja {{ $order->meja->nomor_meja }}</p>
            </div>
            <div>
                <p class="text-sm text-blue-600">Pelayan</p>
                <p class="font-medium text-blue-900">{{ $order->user->name }}</p>
            </div>
            <div>
                <p class="text-sm text-blue-600">Tanggal</p>
                <p class="font-medium text-blue-900">{{ $order->tanggal->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Pesanan</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Item</th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Harga</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($order->detailOrders as $detail)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-3">
                                            @if($detail->masakan->gambar)
                                                <img src="{{ asset('storage/' . $detail->masakan->gambar) }}" 
                                                     alt="{{ $detail->masakan->nama_masakan }}" 
                                                     class="w-10 h-10 rounded-lg object-cover">
                                            @else
                                                <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-utensils text-gray-400 text-sm"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $detail->masakan->nama_masakan }}</p>
                                                @if($detail->keterangan)
                                                    <p class="text-sm text-gray-500">{{ $detail->keterangan }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-gray-900">{{ $detail->jumlah }}</td>
                                    <td class="px-4 py-3 text-right text-gray-900">
                                        Rp. {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium text-gray-900">
                                        Rp. {{ number_format($detail->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 border-t">
                            <tr>
                                <td colspan="3" class="px-4 py-3 text-sm font-medium text-gray-900">Total Harga</td>
                                <td class="px-4 py-3 text-lg font-bold text-blue-600">
                                    Rp. {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($order->keterangan)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">
                            <strong>Catatan Order:</strong> {{ $order->keterangan }}
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pembayaran</h3>
                
                <form method="POST" action="{{ route('kasir.transaksi.store', $order->id_order) }}" id="paymentForm">
                    @csrf
                    
                    <!-- Total Amount -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Total Pembayaran</span>
                            <span class="text-xl font-bold text-blue-600">
                                Rp. {{ number_format($order->total_harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Metode Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="payment-method-option">
                                <input type="radio" name="metode_pembayaran" value="cash" required
                                    class="sr-only peer" onchange="toggleCashFields()">
                                <div class="border-2 rounded-lg p-3 text-center cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50">
                                    <i class="fas fa-money-bill-wave text-green-600 text-xl mb-1"></i>
                                    <p class="text-sm font-medium">Cash</p>
                                </div>
                            </label>
                            
                            <label class="payment-method-option">
                                <input type="radio" name="metode_pembayaran" value="transfer" required
                                    class="sr-only peer" onchange="toggleCashFields()">
                                <div class="border-2 rounded-lg p-3 text-center cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50">
                                    <i class="fas fa-exchange-alt text-blue-600 text-xl mb-1"></i>
                                    <p class="text-sm font-medium">Transfer</p>
                                </div>
                            </label>
                            
                            <label class="payment-method-option">
                                <input type="radio" name="metode_pembayaran" value="kartu" required
                                    class="sr-only peer" onchange="toggleCashFields()">
                                <div class="border-2 rounded-lg p-3 text-center cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50">
                                    <i class="fas fa-credit-card text-purple-600 text-xl mb-1"></i>
                                    <p class="text-sm font-medium">Kartu</p>
                                </div>
                            </label>
                            
                            <label class="payment-method-option">
                                <input type="radio" name="metode_pembayaran" value="ewallet" required
                                    class="sr-only peer" onchange="toggleCashFields()">
                                <div class="border-2 rounded-lg p-3 text-center cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:bg-gray-50">
                                    <i class="fas fa-wallet text-orange-600 text-xl mb-1"></i>
                                    <p class="text-sm font-medium">E-Wallet</p>
                                </div>
                            </label>
                        </div>
                        @error('metode_pembayaran')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Cash Fields -->
                    <div id="cashFields" class="space-y-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Uang Bayar <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp.</span>
                                <input type="number" name="uang_bayar" id="uang_bayar" 
                                    value="{{ old('uang_bayar', $order->total_harga) }}" min="0" step="100"
                                    class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="0" onchange="calculateChange()">
                            </div>
                            @error('uang_bayar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kembalian</label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp.</span>
                                <input type="text" id="kembalian" readonly
                                    class="w-full pl-12 pr-4 py-2 bg-gray-100 border border-gray-300 rounded-lg"
                                    value="0">
                            </div>
                        </div>
                    </div>

                    <!-- Reference Number (for non-cash) -->
                    <div id="referenceFields" class="hidden mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            No. Referensi
                        </label>
                        <input type="text" name="no_referensi"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            placeholder="No. referensi transaksi">
                        <p class="mt-1 text-xs text-gray-500">No. referensi bank/kartu/ewallet</p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-3">
                        <a href="{{ route('kasir.dashboard') }}" 
                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-center">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" 
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            <i class="fas fa-check mr-2"></i>Bayar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const totalHarga = {{ $order->total_harga }};

function toggleCashFields() {
    const selectedMethod = document.querySelector('input[name="metode_pembayaran"]:checked')?.value;
    const cashFields = document.getElementById('cashFields');
    const referenceFields = document.getElementById('referenceFields');
    const uangBayarInput = document.getElementById('uang_bayar');
    
    if (selectedMethod === 'cash') {
        cashFields.classList.remove('hidden');
        referenceFields.classList.add('hidden');
        uangBayarInput.required = true;
        // Auto-fill with exact amount
        uangBayarInput.value = totalHarga;
        calculateChange();
    } else {
        cashFields.classList.add('hidden');
        referenceFields.classList.remove('hidden');
        uangBayarInput.required = false;
        uangBayarInput.value = totalHarga;
        calculateChange();
    }
}

function calculateChange() {
    const uangBayar = parseFloat(document.getElementById('uang_bayar').value) || 0;
    const kembalian = uangBayar - totalHarga;
    
    document.getElementById('kembalian').value = kembalian.toLocaleString('id-ID');
    
    // Change color based on amount
    const kembalianInput = document.getElementById('kembalian');
    if (kembalian < 0) {
        kembalianInput.classList.add('text-red-600');
        kembalianInput.classList.remove('text-green-600');
    } else {
        kembalianInput.classList.add('text-green-600');
        kembalianInput.classList.remove('text-red-600');
    }
}

// Form validation
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const selectedMethod = document.querySelector('input[name="metode_pembayaran"]:checked')?.value;
    
    if (!selectedMethod) {
        e.preventDefault();
        alert('Silakan pilih metode pembayaran!');
        return false;
    }
    
    if (selectedMethod === 'cash') {
        const uangBayar = parseFloat(document.getElementById('uang_bayar').value) || 0;
        if (uangBayar < totalHarga) {
            e.preventDefault();
            alert('Uang bayar tidak mencukupi!');
            return false;
        }
    }
    
    return true;
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Set default to cash
    document.querySelector('input[value="cash"]').checked = true;
    toggleCashFields();
});
</script>
@endsection
