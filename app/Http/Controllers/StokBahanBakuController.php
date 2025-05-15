<?php

namespace App\Http\Controllers;

use App\Models\StokBahanBaku;
use Illuminate\Http\Request;

class StokBahanBakuController extends Controller
{
    public function index()
    {
        $stok = StokBahanBaku::latest()->paginate(10);
        return view('admin.stok.index', compact('stok'));
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
}
