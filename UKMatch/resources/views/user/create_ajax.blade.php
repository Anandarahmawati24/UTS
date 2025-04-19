<form id="form-user" action="{{ route('user.store_ajax') }}" method="POST">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Level Pengguna</label>
                    <select name="id_level" id="id_level" class="form-control" required>
                        <option value="">- Pilih Level -</option>
                        @foreach($level as $l)
                        <option value="{{ $l->id_level }}">{{ $l->level_nama }}</option>
                        @endforeach
                    </select>
                    <small id="error-id_level" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                    <small id="error-username" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                    <small id="error-nama" class="error-text form-text text-danger"></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <small id="error-password" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" id="submit-btn" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#form-user").validate({
        rules: {
            id_level: { required: true, number: true },
            username: { required: true, minlength: 3, maxlength: 20 },
            nama: { required: true, minlength: 3, maxlength: 100 },
            password: { required: true, minlength: 6, maxlength: 20 }
        },
        messages: {
            id_level: {
                required: "Pilih level pengguna",
                number: "Level harus berupa angka"
            },
            username: {
                required: "Username wajib diisi",
                minlength: "Minimal 3 karakter",
                maxlength: "Maksimal 20 karakter"
            },
            password: {
                required: "Password wajib diisi",
                minlength: "Minimal 6 karakter"
            }
        },
        submitHandler: function(form) {
    const submitBtn = $('#submit-btn');
    submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');

    $.ajax({
        url: form.action,
        type: form.method,
        data: $(form).serialize(),
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Header penting untuk deteksi AJAX
        },
        success: function(response) {
            if (response.status) {
                $('#myModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                    timer: 2000
                });
                dataUser.ajax.reload();
            }
        },
        error: function(xhr) {
            // Handle 422 (Validation Errors)
            if (xhr.status === 422) {
                $('.error-text').text('');
                $.each(xhr.responseJSON.errors, function(prefix, val) {
                    $('#error-' + prefix).text(val[0]);
                });
            } 
            // Handle 302 Redirect (jika masih terjadi)
            else if (xhr.status === 302) {
                // Coba parse response JSON jika ada
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.status === false) {
                        $('.error-text').text('');
                        $.each(response.errors, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                    }
                } catch (e) {
                    // Jika benar-benar redirect
                    window.location.href = xhr.getResponseHeader('Location') || '/user';
                }
            }
            else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: xhr.responseJSON?.message || 'Terjadi kesalahan server'
                });
            }
        },
        complete: function() {
            submitBtn.prop('disabled', false).html('Simpan');
        }
    });
    return false;
}
    });
});
</script>