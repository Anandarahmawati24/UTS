@extends('layouts.template')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @if(empty($ukm))
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>Nama UKM</th>
                    <td>{{ $ukm->nama_ukm }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $ukm->email }}</td>
                </tr>
                <tr>
                    <th>Kategori</th>
                    <td>{{ $ukm->kategori?->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $ukm->status }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $ukm->alamat}}</td>
                </tr>
                <tr>
                <tr>
                    <th>Tanggal Berdiri</th>
                    <td>{{ $ukm->tanggal_berdiri}}</td>
                </tr>
                <tr>
                <tr>
                    <th>Deskripsi UKM</th>
                    <td>{{ $ukm->deskripsi}}</td>
                </tr>
                <tr>
            </table>
        @endif
        <a href="{{ url('ukm') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush