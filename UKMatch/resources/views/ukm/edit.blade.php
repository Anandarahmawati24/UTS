@extends('layouts.template')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($ukm)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('ukm') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else

        <form method="POST" action="{{ url('/ukm/'.$ukm->id_ukm) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!}

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama UKM</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="nama_ukm" name="nama_ukm" 
                        value="{{ old('nama_ukm', $ukm->nama_ukm) }}" required>
                    @error('nama_ukm')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Email</label>
                <div class="col-10">
                    <input type="email" class="form-control" id="email" name="email" 
                        value="{{ old('email', $ukm->email) }}" required>
                    @error('email')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Kategori</label>
                <div class="col-10">
                    <select class="form-control" name="id_kategori" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori_list as $kategori)
                        <option value="{{ $kategori->id_kategori }}"
                            {{ $ukm->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_kategori')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Status</label>
                <div class="col-10">
                    <select class="form-control" name="status" required>
                        <option value="1" {{ $ukm->status == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ $ukm->status == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('ukm') }}">Kembali</a>
                </div>
            </div>
        </form>

        @endempty
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush