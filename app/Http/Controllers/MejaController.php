<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meja;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class MejaController extends Controller
{
    public function __construct()
    {
        // Middleware will be handled by routes
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mejas = Meja::when($request->search, function($query, $search) {
                $query->where('nomor_meja', 'like', "%{$search}%");
            })
            ->when($request->status, function($query, $status) {
                $query->where('status_meja', $status);
            })
            ->orderBy('nomor_meja')
            ->paginate(12);

        $statusList = ['tersedia', 'terisi', 'dipesan', 'maintenance'];
        
        return view('admin.mejas.index', compact('mejas', 'statusList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.mejas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:10|unique:mejas,nomor_meja',
            'kapasitas' => 'required|integer|min:1|max:20',
            'lokasi' => 'nullable|string|max:50',
            'status_meja' => 'required|in:tersedia,terisi,dipesan,maintenance',
            'deskripsi' => 'nullable|string|max:200',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $data = $request->except('qr_code');
        
        if ($request->hasFile('qr_code')) {
            $qrCode = $request->file('qr_code');
            $qrCodePath = $qrCode->store('mejas', 'public');
            $data['qr_code'] = $qrCodePath;
        }

        // Generate QR code if not provided
        if (!$request->hasFile('qr_code')) {
            $data['qr_code'] = $this->generateQRCode($request->nomor_meja);
        }

        Meja::create($data);

        return redirect()->route('admin.mejas.index')
            ->with('success', 'Meja berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Meja $meja)
    {
        // Get current and recent orders for this table
        $currentOrder = Order::where('id_meja', $meja->id_meja)
            ->whereIn('status_order', ['menunggu', 'diproses'])
            ->with(['user', 'detailOrders.masakan'])
            ->first();

        $recentOrders = Order::where('id_meja', $meja->id_meja)
            ->with(['user'])
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        return view('admin.mejas.show', compact('meja', 'currentOrder', 'recentOrders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Meja $meja)
    {
        return view('admin.mejas.edit', compact('meja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Meja $meja)
    {
        $request->validate([
            'nomor_meja' => 'required|string|max:10|unique:mejas,nomor_meja,' . $meja->id_meja . ',id_meja',
            'kapasitas' => 'required|integer|min:1|max:20',
            'lokasi' => 'nullable|string|max:50',
            'status_meja' => 'required|in:tersedia,terisi,dipesan,maintenance',
            'deskripsi' => 'nullable|string|max:200',
            'qr_code' => 'nullable|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        $data = $request->except('qr_code');
        
        if ($request->hasFile('qr_code')) {
            // Delete old QR code
            if ($meja->qr_code) {
                Storage::disk('public')->delete($meja->qr_code);
            }
            
            $qrCode = $request->file('qr_code');
            $qrCodePath = $qrCode->store('mejas', 'public');
            $data['qr_code'] = $qrCodePath;
        }

        $meja->update($data);

        return redirect()->route('admin.mejas.index')
            ->with('success', 'Meja berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Meja $meja)
    {
        // Check if meja has active orders
        if ($meja->orders()->whereIn('status_order', ['menunggu', 'diproses'])->count() > 0) {
            return back()->with('error', 'Meja tidak dapat dihapus karena memiliki pesanan aktif!');
        }

        // Delete QR code if exists
        if ($meja->qr_code && !str_contains($meja->qr_code, 'generated')) {
            Storage::disk('public')->delete($meja->qr_code);
        }

        $meja->delete();

        return back()->with('success', 'Meja berhasil dihapus!');
    }

    /**
     * Toggle status meja
     */
    public function toggleStatus(Meja $meja)
    {
        $statusFlow = [
            'tersedia' => 'terisi',
            'terisi' => 'dipesan', 
            'dipesan' => 'maintenance',
            'maintenance' => 'tersedia'
        ];

        $currentStatus = $meja->status_meja;
        $newStatus = $statusFlow[$currentStatus] ?? 'tersedia';

        // Additional validation
        if ($newStatus === 'tersedia' && $meja->orders()->whereIn('status_order', ['menunggu', 'diproses'])->count() > 0) {
            return back()->with('error', 'Meja tidak dapat diubah ke tersedia karena masih ada pesanan aktif!');
        }

        $meja->update(['status_meja' => $newStatus]);

        return back()->with('success', "Status meja diubah menjadi {$newStatus}!");
    }

    /**
     * Generate QR code for table
     */
    private function generateQRCode($nomorMeja)
    {
        // For now, return a placeholder path
        // In production, you'd use a QR code generation library
        return "generated/qr_meja_{$nomorMeja}.png";
    }

    /**
     * Download QR code
     */
    public function downloadQR(Meja $meja)
    {
        if (!$meja->qr_code) {
            return back()->with('error', 'QR Code tidak tersedia!');
        }

        if (str_contains($meja->qr_code, 'generated')) {
            return back()->with('error', 'QR Code belum di-generate!');
        }

        $filePath = storage_path('app/public/' . $meja->qr_code);
        if (!file_exists($filePath)) {
            return back()->with('error', 'File QR Code tidak ditemukan!');
        }

        return response()->download($filePath, "QR_Meja_{$meja->nomor_meja}.png");
    }
}
