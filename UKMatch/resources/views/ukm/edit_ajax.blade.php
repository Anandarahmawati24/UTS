@empty($ukm)
<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger">
                <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                Data yang anda cari tidak ditemukan
            </div>
            <a href="{{ url('/ukm') }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</div>
@else
<form action="{{ url('/ukm/' . $ukm->id_ukm . '/update_ajax') }}" method="POST" id="form-edit-ukm">
    @csrf
    @method('PUT')
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit UKM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama UKM</label>
                    <input value="{{ $ukm->nama_ukm }}" type="text" name="nama_ukm" id="nama_ukm" class="form-control" required>
                    <small id="error-nama_ukm" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori_ukm as $kategori)
                            <option value="{{ $kategori->id_kategori }}" {{ $ukm->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                                {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <small id="error-id_kategori" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input value="{{ $ukm->email }}" type="email" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" required>{{ $ukm->alamat }}</textarea>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required>{{ $ukm->deskripsi }}</textarea>
                    <small id="error-deskripsi" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Berdiri</label>
                    <input value="{{ $ukm->tanggal_berdiri }}" type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required>
                    <small id="error-tanggal_berdiri" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif" {{ $ukm->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ $ukm->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    <small id="error-status" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form-edit-ukm").validate({
            rules: {
                nama_ukm: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                id_kategori: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                alamat: {
                    required: true
                },
                deskripsi: {
                    required: true
                },
                tanggal_berdiri: {
                    required: true,
                    date: true
                },
                status: {
                    required: true
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataUkm.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endempty