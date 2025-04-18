@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @if(empty($kategori))
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                Data yang Anda cari tidak ditemukan.
            </div>
        @else
            <table class="table table-bordered table-striped table-hover table-sm">
                <tr>
                    <th>ID Kategori</th>
                    <td>{{ $kategori->id_kategori }}</td>
                </tr>
                <tr>
                    <th>Nama Kategori UKM</th>
                    <td>{{ $kategori->nama_kategori }}</td>
                </tr>
                <tr>
                    <th>Tanggal Dibuat</th>
                    <td>{{ \Carbon\Carbon::parse($kategori->created_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Tanggal Diperbarui</th>
                    <td>{{ \Carbon\Carbon::parse($kategori->updated_at)->format('d/m/Y H:i:s') }}</td>
                </tr>
            </table>
        @endif
        <div class="mt-2">
            <a href="{{ url('kategori_ukm') }}" class="btn btn-sm btn-default">Kembali</a>
            <a href="{{ url('kategori_ukm/'.$kategori->id_kategori.'/edit') }}" class="btn btn-sm btn-warning ml-1">Edit</a>
        </div>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush