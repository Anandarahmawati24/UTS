<form action="{{ url('/kategori_ukm/ajax') }}" method="POST" id="form-tambah-kategori">
    @csrf
    <div id="myModal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Kategori UKM</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Nama Kategori</label>
                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control" required>
                    <small id="error-nama_kategori" class="text-danger"></small>
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
        // Validasi form tambah kategori UKM
        $("#form-tambah-kategori").validate({
            rules: {
                nama_kategori: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                }
            },
            messages: {
                nama_kategori: {
                    required: "Nama Kategori wajib diisi",
                    minlength: "Nama Kategori minimal 3 karakter",
                    maxlength: "Nama Kategori maksimal 100 karakter"
                }
            },
            submitHandler: function(form) {
                // Mengirim data via AJAX
                $.ajax({
                    url: $(form).attr('action'),
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#myModal').modal('hide');  // Menutup modal setelah berhasil
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataKategoriUkm.ajax.reload(); // Reload DataTable
                        } else {
                            $('.text-danger').text('');
                            if (response.errors) {
                                $.each(response.errors, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan teknis'
                        });
                    }
                });
                return false;
            }
        });
</script>