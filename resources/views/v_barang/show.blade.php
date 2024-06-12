@extends('layouts.main')

@section('content')
<div class="container">
    <div class="pull-left">
        <h4 class="font-weight-bold mb-3">BARANG</h4>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow rounded">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <table class="table">
                                <tr>
                                    <td class="font-weight-bold">MERK</td>
                                    <td>{{ $rsetBarang->merk }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">SERI</td>
                                    <td>{{ $rsetBarang->seri }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">SPESIFIKASI</td>
                                    <td>{{ $rsetBarang->spesifikasi }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">STOK</td>
                                    <td>{{ $rsetBarang->stok }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">KATEGORI</td>
                                    <td>{{ $rsetBarang->kategori->deskripsi }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <div class="card-title font-weight-bold">GAMBAR</div>
                            @if($rsetBarang->image)
                            <img src="{{ asset('storage/barang/' . $rsetBarang->image) }}" class="rounded" style="max-width: 100%;">
                            @else
                            <p>No Image</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <div class="col-md-1 text-center">
            <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary mb-3">BACK</a>
        </div>
    </div>
</div>
@endsection
