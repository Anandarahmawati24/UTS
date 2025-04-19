<form action="{{ url('/ukm/ajax') }}" method="POST" id="form-tambah-ukm">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah UKM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama UKM</label>
                    <input type="text" name="nama_ukm" id="nama_ukm" class="form-control" required>
                    <small id="error-nama_ukm" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Kategori UKM</label>
                    <select name="id_kategori" id="id_kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori_ukm as $kategori)
                            <option value="{{ $kategori->id_kategori }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_kategori" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <small id="error-email" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <input type="text" name="alamat" id="alamat" class="form-control" required>
                    <small id="error-alamat" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" required></textarea>
                    <small id="error-deskripsi" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Tanggal Berdiri</label>
                    <input type="date" name="tanggal_berdiri" id="tanggal_berdiri" class="form-control" required>
                    <small id="error-tanggal_berdiri" class="text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <small id="error-status" class="text-danger"></small>
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
        $("#form-tambah-ukm").validate({
            rules: {
                nama_ukm: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                id_kategori: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                alamat: {
                    required: true,
                    minlength: 3
                },
                deskripsi: {
                    required: true,
                    minlength: 5
                },
                tanggal_berdiri: {
                    required: true,
                    date: true
                },
                status: {
                    required: true
                }
            },
            messages: {
                nama_ukm: {
                    required: "Nama UKM wajib diisi",
                    minlength: "Nama UKM minimal 3 karakter",
                    maxlength: "Nama UKM maksimal 100 karakter"
                },
                id_kategori: {
                    required: "Kategori UKM wajib dipilih"
                },
                email: {
                    required: "Email wajib diisi",
                    email: "Format email tidak valid"
                },
                alamat: {
                    required: "Alamat wajib diisi",
                    minlength: "Alamat minimal 3 karakter"
                },
                deskripsi: {
                    required: "Deskripsi wajib diisi",
                    minlength: "Deskripsi minimal 5 karakter"
                },
                tanggal_berdiri: {
                    required: "Tanggal Berdiri wajib diisi",
                    date: "Format tanggal tidak valid"
                },
                status: {
                    required: "Status wajib dipilih"
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
                            dataUkm.ajax.reload(); // Reload DataTables UKM
                        } else {
                            $('.text-danger').text('');
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