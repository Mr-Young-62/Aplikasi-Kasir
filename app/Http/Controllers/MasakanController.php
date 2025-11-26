<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Masakan;
use Illuminate\Support\Facades\Storage;

class MasakanController extends Controller
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
        $masakans = Masakan::when($request->search, function($query, $search) {
                $query->where('nama_masakan', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%");
            })
            ->when($request->kategori, function($query, $kategori) {
                $query->where('kategori', $kategori);
            })
            ->when($request->status, function($query, $status) {
                $query->where('status_masakan', $status);
            })
            ->orderBy('nama_masakan')
            ->paginate(10);

        $kategoriList = Masakan::distinct()->pluck('kategori')->filter();
        
        return view('admin.masakans.index', compact('masakans', 'kategoriList'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoriList = ['Makanan', 'Minuman', 'Dessert', 'Appetizer', 'Lainnya'];
        return view('admin.masakans.create', compact('kategoriList'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_masakan' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'status_masakan' => 'required|in:tersedia,habis',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('masakans', 'public');
            $data['gambar'] = $gambarPath;
        }

        Masakan::create($data);

        return redirect()->route('admin.masakans.index')
            ->with('success', 'Masakan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Masakan $masakan)
    {
        return view('admin.masakans.show', compact('masakan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Masakan $masakan)
    {
        $kategoriList = ['Makanan', 'Minuman', 'Dessert', 'Appetizer', 'Lainnya'];
        return view('admin.masakans.edit', compact('masakan', 'kategoriList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Masakan $masakan)
    {
        $request->validate([
            'nama_masakan' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string|max:500',
            'status_masakan' => 'required|in:tersedia,habis',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->except('gambar');
        
        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($masakan->gambar) {
                Storage::disk('public')->delete($masakan->gambar);
            }
            
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->store('masakans', 'public');
            $data['gambar'] = $gambarPath;
        }

        $masakan->update($data);

        return redirect()->route('admin.masakans.index')
            ->with('success', 'Masakan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masakan $masakan)
    {
        // Check if masakan has related orders
        if ($masakan->detailOrders()->count() > 0) {
            return back()->with('error', 'Masakan tidak dapat dihapus karena memiliki data terkait!');
        }

        // Delete image if exists
        if ($masakan->gambar) {
            Storage::disk('public')->delete($masakan->gambar);
        }

        $masakan->delete();

        return back()->with('success', 'Masakan berhasil dihapus!');
    }

    /**
     * Toggle status masakan
     */
    public function toggleStatus(Masakan $masakan)
    {
        $newStatus = $masakan->status_masakan === 'tersedia' ? 'habis' : 'tersedia';
        $masakan->update(['status_masakan' => $newStatus]);

        return back()->with('success', "Status masakan diubah menjadi {$newStatus}!");
    }
}
