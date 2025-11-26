<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MasakanController;
use App\Http\Controllers\MejaController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Admin Routes (resources)
Route::middleware(['auth', 'check.role:Administrator'])->prefix('admin')->name('admin.')->group(function () {
    // Resource routes for master data
    Route::resource('users', UserController::class);
    Route::resource('masakans', MasakanController::class);
    Route::resource('mejas', MejaController::class);
    
    // Additional masakan routes
    Route::patch('masakans/{masakan}/toggle-status', [MasakanController::class, 'toggleStatus'])->name('masakans.toggle-status');
    
    // Additional meja routes
    Route::patch('mejas/{meja}/toggle-status', [MejaController::class, 'toggleStatus'])->name('mejas.toggle-status');
    Route::get('mejas/{meja}/download-qr', [MejaController::class, 'downloadQR'])->name('mejas.download-qr');
});

// Waiter Routes
Route::middleware(['auth'])->prefix('waiter')->name('waiter.')->group(function () {
    Route::get('/dashboard', [WaiterController::class, 'dashboard'])->name('dashboard');
    Route::get('/order/create', [WaiterController::class, 'createOrder'])->name('order.create');
    Route::post('/order', [WaiterController::class, 'storeOrder'])->name('order.store');
    Route::get('/order/{id_order}/edit', [WaiterController::class, 'editOrder'])->name('order.edit');
    Route::put('/order/{id_order}', [WaiterController::class, 'updateOrder'])->name('order.update');
    Route::post('/order/{id_order}/add-detail', [WaiterController::class, 'addDetailOrder'])->name('order.add-detail');
    Route::delete('/detail-order/{id_detail_order}', [WaiterController::class, 'removeDetailOrder'])->name('detail-order.destroy');
});

// Kasir Routes
Route::middleware(['auth'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [KasirController::class, 'listOrders'])->name('orders.index');
    Route::get('/transaksi', [KasirController::class, 'listTransaksi'])->name('transaksi.index');
    Route::get('/transaksi/create/{id_order}', [KasirController::class, 'createTransaksi'])->name('transaksi.create');
    Route::post('/transaksi/{id_order}', [KasirController::class, 'storeTransaksi'])->name('transaksi.store');
    Route::get('/transaksi/{id_transaksi}', [KasirController::class, 'showTransaksi'])->name('transaksi.show');
    Route::get('/transaksi/{id_transaksi}/print', [KasirController::class, 'printStruk'])->name('transaksi.print');
    Route::delete('/transaksi/{id_transaksi}', [KasirController::class, 'cancelTransaksi'])->name('transaksi.cancel');
});

// Owner Routes
Route::middleware(['auth', 'check.role:Owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');
    Route::get('/laporan/penjualan', [OwnerController::class, 'laporanPenjualan'])->name('laporan.penjualan');
    Route::get('/laporan/masakan', [OwnerController::class, 'laporanMasakan'])->name('laporan.masakan');
    Route::get('/laporan/waiter', [OwnerController::class, 'laporanWaiter'])->name('laporan.waiter');
    Route::get('/laporan/pelanggan', [OwnerController::class, 'laporanPelanggan'])->name('laporan.pelanggan');
});

// Admin Routes (Dashboard only - resources already defined above)
Route::middleware(['auth', 'check.role:Administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Waiter Routes
Route::middleware(['auth', 'check.role:Waiter'])->prefix('waiter')->name('waiter.')->group(function () {
    Route::get('/dashboard', [WaiterController::class, 'dashboard'])->name('dashboard');
});

// Kasir Routes
Route::middleware(['auth', 'check.role:Kasir'])->prefix('kasir')->name('kasir.')->group(function () {
    Route::get('/dashboard', [KasirController::class, 'dashboard'])->name('dashboard');
});

// Pelanggan Routes
Route::middleware(['auth', 'check.role:Pelanggan'])->prefix('pelanggan')->name('pelanggan.')->group(function () {
    Route::get('/dashboard', [PelangganController::class, 'dashboard'])->name('dashboard');
    Route::get('/menu', [PelangganController::class, 'menu'])->name('menu');
    Route::get('/menu/kategori/{kategori}', [PelangganController::class, 'menuByCategory'])->name('menu.category');
    Route::get('/menu/search', [PelangganController::class, 'searchMenu'])->name('menu.search');
    Route::get('/menu/{id_masakan}', [PelangganController::class, 'showMenu'])->name('menu.show');
    Route::get('/order/create', [PelangganController::class, 'createSelfOrder'])->name('order.create');
    Route::post('/order', [PelangganController::class, 'storeSelfOrder'])->name('order.store');
    Route::get('/orders', [PelangganController::class, 'myOrders'])->name('orders');
    Route::get('/order/{id_order}', [PelangganController::class, 'showOrder'])->name('order.show');
    Route::delete('/order/{id_order}', [PelangganController::class, 'cancelOrder'])->name('order.cancel');
});

// Redirect authenticated users to their dashboard
Route::middleware(['auth'])->get('/redirect', function () {
    $user = auth()->user();
    
    return match($user->level->nama_level) {
        'Administrator' => redirect()->route('admin.dashboard'),
        'Waiter' => redirect()->route('waiter.dashboard'),
        'Kasir' => redirect()->route('kasir.dashboard'),
        'Owner' => redirect()->route('owner.dashboard'),
        'Pelanggan' => redirect()->route('pelanggan.dashboard'),
        default => redirect()->route('home'),
    };
})->name('redirect');
