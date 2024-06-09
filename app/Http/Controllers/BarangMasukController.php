<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tgl_masuk = $request->input('tgl_masuk');
    
        $rsetBarangMasuk = BarangMasuk::with('barang')
                        ->when($search, function ($query, $search) {
                            return $query->whereHas('barang', function($q) use ($search) {
                                $q->where('merk', 'like', '%' . $search . '%')
                                  ->orWhere('seri', 'like', '%' . $search . '%');
                            });
                        })
                        ->when($tgl_masuk, function ($query, $tgl_masuk) {
                            return $query->whereDate('tgl_masuk', $tgl_masuk);
                        })
                        ->latest()
                        ->paginate(10);
    
        return view('barangmasuk.index', compact('rsetBarangMasuk'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    
    
    public function create()
    {
        $abarangmasuk = Barang::all();
        return view('barangmasuk.create',compact('abarangmasuk'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tgl_masuk'     => 'required',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required',
        ]);
        //create post
        BarangMasuk::create([
            'tgl_masuk'        => $request->tgl_masuk,
            'qty_masuk'        => $request->qty_masuk,
            'barang_id'        => $request->barang_id,
        ]);

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }


    public function show($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        return view('barangmasuk.show', compact('barangMasuk'));
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $abarangmasuk = Barang::all();

        return view('barangmasuk.edit', compact('barangMasuk', 'abarangmasuk'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'tgl_masuk'     => 'required',
            'qty_masuk'     => 'required|numeric|min:1',
            'barang_id'     => 'required',
        ]);
        //create post
        $barangMasuk = BarangMasuk::findOrFail($id);
            $barangMasuk->update([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id,
            ]);

        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Diupdate!']);
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
    
        // Check if there are related barang keluar
        $relatedBarangKeluar = BarangKeluar::where('barang_id', $barangMasuk->barang_id)->exists();
        if ($relatedBarangKeluar) {
            return redirect()->route('barangmasuk.index')->with(['error' => 'Tidak dapat menghapus barang masuk yang telah memiliki barang keluar terkait!']);
        }
    
        // If there are no related barang keluar, proceed with deletion
        $barangMasuk->delete();
    
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
    
    

}