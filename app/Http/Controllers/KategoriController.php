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
            ->select('kategori.id', 'deskripsi', 'kategori', DB::raw('ketKategorik(kategori.kategori) as ket'))
            ->when($search, function ($query, $search) {
                return $query->where('deskripsi', 'like', '%' . $search . '%')
                             ->orWhere('kategori', 'like', '%' . $search . '%')
                             ->orWhere(DB::raw('ketKategorik(kategori.kategori) COLLATE utf8mb4_unicode_ci'), 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);
    
        $kategori->appends(['search' => $search]);
    
        $i = (request()->input('page', 1) - 1) * 10;
    
        return view('v_kategori.index', compact('rsetKategori', 'kategori'))->with('i', $i);
    }
    
    public function create()
    {
        $akategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('v_kategori.create',compact('akategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|unique:kategori,deskripsi',
            'kategori' => 'required|in:M,A,BHP,BTHP',
        ]);
    
        DB::beginTransaction();
    
        try {
            Kategori::create([
                'deskripsi' => $request->deskripsi,
                'kategori'  => $request->kategori,
            ]);
    
            DB::commit();
    
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with(['error' => 'Terjadi kesalahan saat menyimpan data. Perubahan dibatalkan.']);
        }
    }    
    
    public function show($id)
    {
        $kategori = DB::table('kategori')
            ->select('kategori.id', 'deskripsi', 'kategori', DB::raw('ketKategorik(kategori.kategori) as ket'))
            ->where('id', $id)
            ->first();
    
        return view('v_kategori.show', compact('kategori'));
    }
    
    public function edit(string $id)
    {
        $rsetKategori = Kategori::find($id);
        return view('v_kategori.edit', compact('rsetKategori'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'deskripsi'   => 'required|unique:kategori,deskripsi,' . $id,
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

