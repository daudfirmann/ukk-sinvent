@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold mb-3 mt-3">DAFTAR BARANG</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                    @endif

                    @if ($error = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{ $error }}</p>
                    </div>
                    @endif

                    @if ($error = Session::get('gagal'))
                    <div class="alert alert-danger">
                        <p>{{ $error }}</p>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <a href="{{ route('barang.create') }}" class="btn btn-md btn-success">TAMBAH BARANG</a>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('barang.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request()->input('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                    @if(request()->filled('search'))
                                        <div class="input-group-append">
                                            <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>NO</th>
                                <th>MERK</th>
                                <th>SERI</th>
                                <th>SPESIFIKASI</th>
                                <th>STOK</th>
                                <th>KATEGORI</th>
                                <th>GAMBAR</th>
                                <th style="width: 15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rsetBarang as $rowbarang)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                <td>{{ $rowbarang->merk }}</td>
                                <td>{{ $rowbarang->seri }}</td>
                                <td>{{ $rowbarang->spesifikasi }}</td>
                                <td class="text-center">{{ $rowbarang->stok }}</td>
                                <td>{{ $rowbarang->kategori->deskripsi }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/barang/' . $rowbarang->image) }}" class="rounded" style="max-width: 150px;">
                                </td>
                                <td class="text-center">
                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $rowbarang->id) }}" method="POST">
                                        <a href="{{ route('barang.show', $rowbarang->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('barang.edit', $rowbarang->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center">- Data barang belum tersedia -</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {!! $rsetBarang->links('pagination::bootstrap-5') !!}
        </div>
    </div>
</div>
@endsection
