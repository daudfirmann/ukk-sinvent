<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ApiKategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        $data = array("data"=>$kategori);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        \Log::info('Store method called', $request->all());
    
        $request->validate([
            'deskripsi'   => 'required',
            'kategori'    => 'required',
        ]);
        
        $kategoribaru = Kategori::create([
            'deskripsi'  => $request->deskripsi,
            'kategori'   => $request->kategori,
        ]);
    
        return response()->json(['message' => 'Kategori berhasil dibuat']);
    }
    
    public function show(string $id)
    {   
        $kategori = Kategori::find($id);
        
        if(!$kategori){
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }else{
            $data=array("data"=>$kategori);
            return response()->json($data);
        }
    }

    public function update(Request $request, string $id)
    {
        $kategori = Kategori::find($id);

        $request->validate([
            'deskripsi'   => 'required',
            'kategori'    => 'required',
        ]);
        
        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }else{
            $kategori->update([
                'deskripsi'=>$request->deskripsi,
                'kategori'=>$request->kategori,
            ]);

        return response()->json(['message' => 'Kategori berhasil diubah'], 200);          
        }
    }

    public function destroy(string $id)
    {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        
        try {
            $kategori->delete();
            return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
        } catch (\Illuminate\Database\QueryException) {
            return response()->json(['message' => 'Kategori tidak dapat dihapus'], 500);
        }
    
    }
}