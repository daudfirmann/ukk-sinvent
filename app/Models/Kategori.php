<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = ['deskripsi','kategori'];

    public static function getKategoriAll(){
        return DB::table('kategori')
            ->select('kategori.id','deskripsi',DB::raw('ketKategorik(kategori) as ket'));
    }

}