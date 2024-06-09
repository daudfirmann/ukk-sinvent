@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold mb-3 mt-3">DAFTAR BARANG MASUK</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-7">
                            <a href="{{ route('barangmasuk.create') }}" class="btn btn-md btn-success">TAMBAH BARANG MASUK</a>
                        </div>
                        <div class="col-md-5">
                            <form action="{{ route('barangmasuk.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request()->input('search') }}">
                                    <input type="date" name="tgl_masuk" class="form-control" value="{{ request()->input('tgl_masuk') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                    @if(request()->filled('search') || request()->filled('tgl_masuk'))
                                        <div class="input-group-append">
                                            <a href="{{ route('barangmasuk.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
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
                                <th>TANGGAL MASUK</th>
                                <th>JUMLAH MASUK</th>
                                <th>STOK</th>
                                <th>BARANG</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rsetBarangMasuk as $rowbarangmasuk)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>{{ $rowbarangmasuk->tgl_masuk }}</td>
                                    <td class="text-center">{{ $rowbarangmasuk->qty_masuk }}</td>
                                    <td class="text-center">{{ $rowbarangmasuk->barang->stok }}</td>
                                    <td>{{ $rowbarangmasuk->barang->merk }} {{ $rowbarangmasuk->barang->seri }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('barangmasuk.destroy', $rowbarangmasuk->id) }}" method="POST">
                                            <a href="{{ route('barangmasuk.show', $rowbarangmasuk->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('barangmasuk.edit', $rowbarangmasuk->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">- Data barang masuk belum tersedia -</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {!! $rsetBarangMasuk->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
