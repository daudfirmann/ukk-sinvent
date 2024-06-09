@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="font-weight-bold">DEATIL BARANG KELUAR</div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-2 font-weight-bold">Tanggal Keluar</div>
                            <div class="col-md-1 font-weight-bold text-right">:</div>
                            <div class="col-md-9">{{ $barangKeluar->tgl_keluar }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2 font-weight-bold">Jumlah Keluar</div>
                            <div class="col-md-1 font-weight-bold text-right">:</div>
                            <div class="col-md-9">{{ $barangKeluar->qty_keluar }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2 font-weight-bold">Stok</div>
                            <div class="col-md-1 font-weight-bold text-right">:</div>
                            <div class="col-md-9">{{ $barangKeluar->barang->stok }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-2 font-weight-bold">Barang</div>
                            <div class="col-md-1 font-weight-bold text-right">:</div>
                            <div class="col-md-9">{{ $barangKeluar->barang->merk }} {{ $barangKeluar->barang->seri }}</div>
                        </div>

                        <a href="{{ route('barangkeluar.index') }}" class="btn btn-primary mt-3">BACK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection