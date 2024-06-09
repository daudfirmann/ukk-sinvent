@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="pull-left">
            <h4 class="font-weight-bold mb-3">KATEGORI</h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td class="font-weight-bold">DESKRIPSI</td>
                                <td>{{ $kategori->deskripsi }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">KATEGORI</td>
                                <td>{{ $kategori->kategori }}</td>
                            </tr>
                            <tr>
                                <td class="font-weight-bold">KETERANGAN</td>
                                <td>{{ $kategori->ketKategorik }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-md-1 text-center">
                <a href="{{ route('kategori.index') }}" class="btn btn-md btn-primary mb-3">BACK</a>
            </div>
        </div>
    </div>
@endsection
