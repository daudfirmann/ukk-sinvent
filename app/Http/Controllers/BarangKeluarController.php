<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tgl_keluar = $request->input('tgl_keluar');
    
        $rsetBarangKeluar = BarangKeluar::with('barang')
                        ->when($search, function ($query, $search) {
                            return $query->whereHas('barang', function($q) use ($search) {
                                $q->where('merk', 'like', '%' . $search . '%')
                                  ->orWhere('seri', 'like', '%' . $search . '%');
                            });
                        })
                        ->when($tgl_keluar, function ($query, $tgl_keluar) {
                            return $query->whereDate('tgl_keluar', $tgl_keluar);
                        })
                        ->latest()
                        ->paginate(10);
    
        return view('barangkeluar.index', compact('rsetBarangKeluar'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function create()
    {
        $abarangkeluar = Barang::all();
        return view('barangkeluar.create',compact('abarangkeluar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tgl_keluar'  => 'required',
            'qty_keluar'  => 'required|integer|min:1',
            'barang_id'   => 'required|exists:barang,id',
        ]);

        $barang = Barang::find($request->barang_id);

        // Get the earliest tanggal_masuk for the specified barang_id
        $earliestTanggalMasuk = BarangMasuk::where('barang_id', $request->barang_id)
        ->orderBy('tgl_masuk', 'asc')
        ->value('tgl_masuk');

        if ($earliestTanggalMasuk && strtotime($request->tgl_keluar) < strtotime($earliestTanggalMasuk)) {
            return redirect()->back()->withInput()->withErrors(['tgl_keluar' => 'Tanggal keluar sebelum tanggal masuk barang!']);
        }

        // Check if enough stock is available
        if ($barang->stok < $request->qty_keluar) {
            return redirect()->back()->withInput()->withErrors(['qty_keluar' => 'Jumlah barang keluar melebihi stok!']);
        }

        BarangKeluar::create([
            'tgl_keluar' => $request->tgl_keluar,
            'qty_keluar' => $request->qty_keluar,
            'barang_id'  => $request->barang_id,
        ]);

        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        return view('barangkeluar.show', compact('barangKeluar'));
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $abarangkeluar = Barang::all();

        return view('barangkeluar.edit', compact('barangKeluar', 'abarangkeluar'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_keluar'  => 'required',
            'qty_keluar'  => 'required|integer|min:1',
            'barang_id'   => 'required|exists:barang,id',
        ]);
    
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::find($request->barang_id);

        // Get the earliest tanggal_masuk for the specified barang_id
        $earliestTanggalMasuk = BarangMasuk::where('barang_id', $request->barang_id)
        ->orderBy('tgl_masuk', 'asc')
        ->value('tgl_masuk');

        if ($earliestTanggalMasuk && strtotime($request->tgl_keluar) < strtotime($earliestTanggalMasuk)) {
            return redirect()->back()->withInput()->withErrors(['tgl_keluar' => 'Tanggal keluar sebelum tanggal masuk barang!']);
        }
    
        // Check if enough stock is available
        $newQtyKeluar = $request->qty_keluar;
        $oldQtyKeluar = $barangKeluar->qty_keluar;
        $diffQty = $newQtyKeluar - $oldQtyKeluar;
    
        if ($barang->stok - $diffQty < 0) {
            return redirect()->back()->withInput()->withErrors(['qty_keluar' => 'Jumlah barang keluar melebihi stok!']);
        }
    
        $barangKeluar->update([
            'tgl_keluar' => $request->tgl_keluar,
            'qty_keluar' => $newQtyKeluar,
            'barang_id'  => $request->barang_id,
        ]);
    
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }    

    public function destroy($id)
    {
        // Menghapus data barang keluar berdasarkan ID
        $barangkeluar = Barangkeluar::findOrFail($id);
        $barangkeluar->delete();
    
        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil dihapus');
    }
    
}
