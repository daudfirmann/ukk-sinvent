<?php
namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $rsetKategori = DB::select('CALL getKategoriAll');

        $kategori = DB::table('kategori')
            ->select('kategori.id', 'deskripsi', 'kategori', DB::raw('ketKategorik(kategori.kategori) as ketKategorik'))
            ->when($search, function ($query, $search) {
                return $query->where('deskripsi', 'like', '%' . $search . '%')
                             ->orWhere(DB::raw('ketKategorik(kategori.kategori) COLLATE utf8mb4_unicode_ci'), 'like', '%' . $search . '%');
                
            })
            ->latest()
            ->paginate(10);

        $i = (request()->input('page', 1) - 1) * 10;

        return view('kategori.index', compact('rsetKategori', 'kategori'))->with('i', $i);
    }
    
    
    public function create()
    {
        $akategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('kategori.create',compact('akategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi'   => 'required',
            'kategori'    => 'required|in:M,A,BHP,BTHP',
        ]);
        // buat kategori baru
        Kategori::create([
            'deskripsi'  => $request->deskripsi,
            'kategori'   => $request->kategori,
        ]);
        //redirect ke kategori index
        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        $kategori = DB::table('kategori')
            ->select('kategori.id', 'deskripsi', 'kategori', DB::raw('ketKategorik(kategori.kategori) as ketKategorik'))
            ->where('id', $id)
            ->first();
    
        return view('kategori.show', compact('kategori'));
    }
    
    public function edit(string $id)
    {
        $rsetKategori = Kategori::find($id);
        return view('kategori.edit', compact('rsetKategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'deskripsi'   => 'required',
            'kategori'    => 'required|in:M,A,BHP,BTHP',
        ]);

        $rsetKategori = Kategori::find($id);
        $rsetKategori->update([
            'deskripsi'  => $request->deskripsi,
            'kategori'   => $request->kategori,
        ]);
        return redirect()->route('kategori.index')->with(['success' => 'Data Kategori Berhasil Diubah!']);
    }

    public function destroy(string $id)
    {
        if (DB::table('barang')->where('kategori_id', $id)->exists()){
            return redirect()->route('kategori.index')->with(['gagal' => 'Data Gagal Dihapus! Data masih digunakan']);            
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }
}
