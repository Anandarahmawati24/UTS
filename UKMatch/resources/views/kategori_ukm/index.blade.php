@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-success mt-1" data-url="{{ url('/kategori_ukm/create_ajax') }}" onclick="modalAction(this)">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_kategori_ukm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection

@push('css')
@endpush

@push('js')
<script>
    // Fungsi untuk memanggil modal
    function modalAction(element) {
        let url = typeof element === "string" ? element : element.getAttribute("data-url");
        $('#myModal').load(url, function() {
            $('#myModal').modal('show');
        });
    }

    var dataKategoriUkm;
    $(document).ready(function() {
        // Inisialisasi DataTable
        dataKategoriUkm = $('#table_kategori_ukm').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('kategori_ukm/list') }}",
                "dataType": "json",
                "type": "POST",
                "data": function(d) {
                    d.kategori_filter = $('#kategori_filter').val(); // Mengirimkan filter ke server
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },
                {
                    data: "nama_kategori",
                    className: "",
                    orderable: true,
                    searchable: true
                },
                {
                    data: "aksi",
                    className: "",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
    // Fungsi untuk memanggil modal dan menampilkan detail kategori
function showDetailKategori(idKategori) {
    $.ajax({
        url: '/kategori_ukm/show/' + idKategori,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                // Memasukkan hasil HTML ke dalam modal body
                $('#modal-kategori-ukm .modal-content').html(response.html);
                $('#modal-kategori-ukm').modal('show');  // Menampilkan modal
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message
                });
            }
        },
        error: function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat memuat data.'
            });
        }
    });
}
</script>
@endpush