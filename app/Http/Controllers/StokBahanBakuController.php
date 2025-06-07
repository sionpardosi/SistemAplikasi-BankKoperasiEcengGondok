<?php

namespace App\Http\Controllers;

use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class StokBahanBakuController extends Controller
{
    // Update method index untuk menampilkan total stok dan status
    public function index()
    {
        $stok = StokBahanBaku::latest()->paginate(10);

        // Hitung total stok saat ini
        $totalStok = StokBahanBaku::sum('jumlah_kg');

        // Hitung statistik
        $statistik = [
            'total_stok' => $totalStok,
            'total_masuk' => StokBahanBaku::where('jumlah_kg', '>', 0)->sum('jumlah_kg'),
            'total_keluar' => abs(StokBahanBaku::where('jumlah_kg', '<', 0)->sum('jumlah_kg')),
            'status_stok' => $this->getStatusStok($totalStok)
        ];

        return view('admin.stok.index', compact('stok', 'statistik'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        StokBahanBaku::create([
            'tanggal' => $request->tanggal,
            'jumlah_kg' => $request->jumlah_kg,
            'sumber' => 'Manual Input',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Stok berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $stok = StokBahanBaku::findOrFail($id);
        return view('admin.stok.edit', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        $stok = StokBahanBaku::findOrFail($id);
        $stok->update([
            'tanggal' => $request->tanggal,
            'jumlah_kg' => $request->jumlah_kg,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('admin.stok.index')->with('success', 'Stok berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $stok = StokBahanBaku::findOrFail($id);
        $stok->delete();

        return back()->with('success', 'Stok berhasil dihapus.');
    }

    // Tambahkan method untuk mengurangi stok (konsumsi produksi)
    public function konsumsi(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jumlah_kg' => 'required|numeric|min:0.1',
            'keterangan' => 'required|string',
        ]);

        $totalStok = StokBahanBaku::sum('jumlah_kg');

        if ($request->jumlah_kg > $totalStok) {
            return back()->with('error', 'Jumlah konsumsi melebihi stok tersedia (' . $totalStok . ' kg)');
        }

        StokBahanBaku::create([
            'tanggal' => $request->tanggal,
            'jumlah_kg' => -$request->jumlah_kg, // NEGATIF untuk pengurangan
            'sumber' => 'Konsumsi Produksi',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Konsumsi stok berhasil dicatat. Stok berkurang ' . $request->jumlah_kg . ' kg');
    }
}
