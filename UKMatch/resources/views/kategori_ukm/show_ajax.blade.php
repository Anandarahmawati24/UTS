<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Kategori UKM</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="alert alert-info">
                <h5><i class="icon fas fa-info-circle"></i> Informasi Kategori UKM</h5>
                Berikut adalah detail informasi kategori UKM yang Anda pilih:
            </div>
            <table class="table table-sm table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>ID Kategori:</th>
                        <td>{{ $kategori->id }}</td>
                    </tr>
                    <tr>
                        <th>Nama Kategori:</th>
                        <td>{{ $kategori->nama_kategori }}</td>
                    </tr>
                    <tr>
                        <th>Created at:</th>
                        <td>{{ $kategori->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Updated at:</th>
                        <td>{{ $kategori->updated_at }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
        </div>
    </div>
</div>