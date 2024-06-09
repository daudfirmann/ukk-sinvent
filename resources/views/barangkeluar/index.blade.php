@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold mb-3 mt-3">DAFTAR BARANG KELUAR</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($error = Session::get('qty_keluar'))
                        <div class="alert alert-danger">
                            <p>{{ $error }}</p>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-7">
                            <a href="{{ route('barangkeluar.create') }}" class="btn btn-md btn-success">TAMBAH BARANG KELUAR</a>
                        </div>
                        <div class="col-md-5">
                            <form action="{{ route('barangkeluar.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request()->input('search') }}">
                                    <input type="date" name="tgl_keluar" class="form-control" value="{{ request()->input('tgl_keluar') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                    @if(request()->filled('search') || request()->filled('tgl_keluar'))
                                        <div class="input-group-append">
                                            <a href="{{ route('barangkeluar.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
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
                                <th>TANGGAL KELUAR</th>
                                <th>JUMLAH KELUAR</th>
                                <th>STOK</th>
                                <th>BARANG</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rsetBarangKeluar as $rowbarangkeluar)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>{{ $rowbarangkeluar->tgl_keluar }}</td>
                                    <td class="text-center">{{ $rowbarangkeluar->qty_keluar }}</td>
                                    <td class="text-center">{{ $rowbarangkeluar->barang->stok }}</td>
                                    <td>{{ $rowbarangkeluar->barang->merk }} {{ $rowbarangkeluar->barang->seri }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('barangkeluar.destroy', $rowbarangkeluar->id) }}" method="POST">
                                            <a href="{{ route('barangkeluar.show', $rowbarangkeluar->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('barangkeluar.edit', $rowbarangkeluar->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">- Data barang keluar belum tersedia -</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {!! $rsetBarangKeluar->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
