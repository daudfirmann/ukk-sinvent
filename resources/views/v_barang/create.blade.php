@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="pull-left">
                <h4 class="font-weight-bold mb-3">TAMBAH BARANG</h4>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="font-weight-bold">MERK</label>
                            <input type="text" class="form-control @error('merk') is-invalid @enderror" name="merk" value="{{ old('merk') }}" placeholder="Masukkan Merk barang">

                            <!-- error message untuk merk -->
                            @error('merk')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">SERI</label>
                            <input type="text" class="form-control @error('seri') is-invalid @enderror" name="seri" value="{{ old('seri') }}" placeholder="Masukkan Seri Barang">

                            <!-- error message untuk seri -->
                            @error('seri')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">SPESIFIKASI</label>
                            <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" name="spesifikasi" value="{{ old('spesifikasi') }}" placeholder="Masukkan Spesifikasi Barang">

                            <!-- error message untuk spesifikasi -->
                            @error('spesifikasi')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">STOK</label>
                            <input type="number" min="0" class="form-control @error('stok') is-invalid @enderror" name="stok" value="0" placeholder="0" readonly>

                            <!-- error message untuk stok -->
                            @error('stok')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">KATEGORI</label>
                            <select class="form-control" name="kategori_id" aria-label="Default select example">
                                <option value="blank">Pilih Kategori</option>
                                @foreach ($akategori as $rowkategori)
                                <option value="{{ $rowkategori->id }}">{{ $rowkategori->deskripsi }}</option>
                                @endforeach
                            </select>
                            
                            @error('kategori_id')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Tambah field untuk mengunggah gambar -->
                        <div class="form-group">
                            <label class="font-weight-bold">GAMBAR</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                                <label class="custom-file-label" for="image">Pilih file</label>
                            </div>
                            @error('image')
                            <div class="alert alert-danger mt-2">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">ADD</button>
                        <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        <a href="{{ route('barang.index') }}" class="btn btn-md btn-danger">BACK</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
