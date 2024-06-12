@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="font-weight-bold">DEATIL BARANG MASUK</div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-2 font-weight-bold">Tanggal Masuk</div>
                        <div class="col-md-1 font-weight-bold text-right">:</div>
                        <div class="col-md-9">{{ $barangMasuk->tgl_masuk }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 font-weight-bold">Jumlah Masuk</div>
                        <div class="col-md-1 font-weight-bold text-right">:</div>
                        <div class="col-md-9">{{ $barangMasuk->qty_masuk }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 font-weight-bold">Stok</div>
                        <div class="col-md-1 font-weight-bold text-right">:</div>
                        <div class="col-md-9">{{ $barangMasuk->barang->stok }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2 font-weight-bold">Barang</div>
                        <div class="col-md-1 font-weight-bold text-right">:</div>
                        <div class="col-md-9">{{ $barangMasuk->barang->merk }} {{ $barangMasuk->barang->seri }}</div>
                    </div>

                    <a href="{{ route('barangmasuk.index') }}" class="btn btn-primary mt-3">BACK</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
