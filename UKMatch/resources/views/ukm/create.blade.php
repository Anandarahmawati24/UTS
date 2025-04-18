@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('ukm') }}" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Kode UKM</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="ukm_kode" name="ukm_kode" value="{{ old('ukm_kode') }}" required>
                    @error('ukm_kode')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Nama UKM</label>
                <div class="col-11">
                    <input type="text" class="form-control" id="ukm_nama" name="ukm_nama" value="{{ old('ukm_nama') }}" required>
                    @error('ukm_nama')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label">Deskripsi</label>
                <div class="col-11">
                    <textarea class="form-control" id="ukm_deskripsi" name="ukm_deskripsi" required>{{ old('ukm_deskripsi') }}</textarea>
                    @error('ukm_deskripsi')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-1 control-label col-form-label"></label>
                <div class="col-11">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('ukm') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush