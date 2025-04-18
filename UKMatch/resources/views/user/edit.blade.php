@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($user)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        <a href="{{ url('user') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
        @else

        <form method="POST" action="{{ url('/user/'.$user->user_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!} <!-- Using PUT method for update -->
            
            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Username</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="username" name="username" 
                        value="{{ old('username', $user->username) }}" required>
                    @error('username')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Nama Lengkap</label>
                <div class="col-10">
                    <input type="text" class="form-control" id="nama" name="nama" 
                        value="{{ old('nama', $user->nama) }}" required>
                    @error('nama')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Password</label>
                <div class="col-10">
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Kosongkan jika tidak ingin mengubah">
                    @error('password')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label">Level</label>
                <div class="col-10">
                    <select class="form-control" id="id_level" name="id_level" required>
                        <option value="">- Pilih Level -</option>
                        @foreach($levelList as $level)
                        <option value="{{ $level->id_level }}" 
                            {{ old('id_level', $user->id_level ?? '') == $level->id_level ? 'selected' : '' }}>
                            {{ $level->level_nama }}
                        </option>
                        @endforeach
                    </select>
                    @error('id_level')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="form-group row">
                <label class="col-2 control-label col-form-label"></label>
                <div class="col-10">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('user') }}">Kembali</a>
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