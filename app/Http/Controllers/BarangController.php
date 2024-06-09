<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $rsetBarang = Barang::with('kategori')
                            ->when($search, function ($query, $search) {
                            return $query->where('merk', 'like', '%' . $search . '%')
                                ->orWhere('seri', 'like', '%' . $search . '%')
                                ->orWhereHas('kategori', function ($query) use ($search) {
                                $query->where('deskripsi', 'like', '%' . $search . '%');
                                });
                        })
                        ->latest()
                        ->paginate(10);
    
        return view('barang.index', compact('rsetBarang'))
        ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    
    public function create()
    {
        $akategori = Kategori::all();
        return view('barang.create',compact('akategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'merk'          => 'required',
            'seri'          => 'required',
            'spesifikasi'   => 'required',
            'stok'          => 'required',
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'kategori_id'   => 'required|exists:kategori,id',

        ]);

        $image = $request->file('image');
        $image->storeAs('public/barang', $image->hashName());

        Barang::create([
            'merk'             => $request->merk,
            'seri'             => $request->seri,
            'spesifikasi'      => $request->spesifikasi,
            'stok'             => $request->stok,
            'image'            => $image->hashName(),
            'kategori_id'      => $request->kategori_id,
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id)
    {
        $rsetBarang = Barang::find($id);

        return view('barang.show', compact('rsetBarang'));
    }

    public function edit(string $id)
    {
    $akategori = Kategori::all();
    $rsetBarang = Barang::find($id);
    $selectedKategori = Kategori::find($rsetBarang->kategori_id);

    return view('barang.edit', compact('rsetBarang', 'akategori', 'selectedKategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'merk'        => 'required',
            'seri'        => 'required',
            'spesifikasi' => 'required',
            'stok'        => 'required',
            'image'       => 'image|mimes:jpeg,jpg,png|max:2048',
            'kategori_id' => 'required',
        ]);

        $rsetBarang = Barang::find($id);

        if ($request->hasFile('image')){

            $image = $request->file('image');
            $image->storeAs('public/barang', $image->hashName());

            Storage::delete('public/barang/'.$rsetBarang->image);

            $rsetBarang->update([
                'merk'          => $request->merk,
                'seri'          => $request->seri,
                'spesifikasi'   => $request->spesifikasi,
                'stok'          => $request->stok,
                'image'         => $image->hashName(),
                'kategori_id'   => $request->kategori_id,
            ]);

        } else {
            $rsetBarang->update([
                'merk'          => $request->merk,
                'seri'          => $request->seri,
                'spesifikasi'   => $request->spesifikasi,
                'stok'          => $request->stok,
                'kategori_id'   => $request->kategori_id,
            ]);
        }
            
        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        $masukTerkait = Barangmasuk::where('barang_id', $id)->exists();
        $keluarTerkait = Barangkeluar::where('barang_id', $id)->exists();
        $stokBarang = Barang::where('id', $id)->where('stok','>',0)->exists();

        // Check if stok is greater than 0 before deleting
        if ($masukTerkait || $keluarTerkait || $stokBarang ) {
            return redirect()->route('barang.index')->with(['error' => 'Barang yang masih terkait atau stok lebih dari 0 tidak dapat dihapus! ']);
        }else{

            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
            return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Dihapus!']);

        }
    }
}