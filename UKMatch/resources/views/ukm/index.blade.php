@extends('layouts.template')

@section('content')
<div class="card card-outline card-success">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <button class="btn btn-sm btn-success mt-1" data-url="{{ url('/ukm/create_ajax') }}" onclick="modalAction(this)">Tambah Ajax</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 control-label col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="kategori_filter" name="kategori_filter">
                            <option value="">- Semua -</option>
                            @foreach($kategori_ukm as $item)
                            <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Filter berdasarkan kategori</small>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_ukm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama UKM</th>
                    <th>Email</th>
                    <th>Kategori</th>
                    <th>Status</th>
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
        function modalAction(element) {
    let url = typeof element === "string" ? element : element.getAttribute("data-url");
    $('#myModal').load(url, function() {
        $('#myModal').modal('show');
    });
}
var dataUkm;
    $(document).ready(function() {
        dataUkm = $('#table_ukm').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('ukm/list') }}",
                "type": "POST",
                "data": function(d) {
                    d.id_kategori = $('#kategori_filter').val();
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
                    data: "nama_ukm"
                },
                {
                    data: "email"
                },
                {
                    data: "nama_kategori" // kolom kategori dari join
                },
                {
                    data: "status",
                    className: "text-center"
                },
                {
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#kategori_filter').on('change', function() {
            dataUkm.ajax.reload();
        });
    });
</script>
@endpush