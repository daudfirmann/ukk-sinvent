@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="font-weight-bold mb-3 mt-3">DAFTAR KATEGORI</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @elseif ($message = Session::get('gagal'))
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-8">
                            <a href="{{ route('kategori.create') }}" class="btn btn-md btn-success">TAMBAH KATEGORI</a>
                        </div>
                        <div class="col-md-4">
                            <form action="{{ route('kategori.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Cari kategori..." value="{{ request()->input('search') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                    </div>
                                    @if(request()->filled('search'))
                                        <div class="input-group-append">
                                            <a href="{{ route('kategori.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
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
                                <th>DESKRIPSI</th>
                                <th>KATEGORI</th>
                                <th>KETERANGAN</th>
                                <th style="width: 15%">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kategori as $rowkategori)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td>{{ $rowkategori->deskripsi }}</td>
                                    <td>{{ $rowkategori->kategori }}</td>
                                    <td>{{ $rowkategori->ketKategorik }}</td>
                                    <td class="text-center">
                                        <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('kategori.destroy', $rowkategori->id) }}" method="POST">
                                            <a href="{{ route('kategori.show', $rowkategori->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('kategori.edit', $rowkategori->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt"></i></a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">- Data kategori belum tersedia -</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {!! $kategori->links('pagination::bootstrap-5') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
