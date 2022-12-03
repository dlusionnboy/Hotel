<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    crosorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js"></script>
<link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<div class="container">
    <button class="float-end btn btn-sm btn-primary" id="btn-tambah">Tambah</button>
    <table id='table-pembayaran' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal </th>
                <th>Tagihan </th>
                <th>Dibayar </th>
                <th>Nama Pembayar </th>
                <th>Metode Bayar</th>
                <th>Pengguna </th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<div id="modalForm" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">pembayaran</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formdibayar" method="post" action="<?=base_url('pembayaran') ?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="form-label">Tanggal </label>
                        <input type="date" name="tanggal" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tagihan</label>
                        <input type="text" name="tagihan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Dibayar </label>
                        <input type="text" name="dibayar" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pembayar </label>
                        <input type="text" name="nama_pembayar" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Bayar</label>
                        <input type="text" name="metodebayar_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengguna </label>
                        <input type="text" name="pengguna_id" class="form-control">
                    </div>
                </form>
                    <div class="modal-footer">
                        <button class="btn btn-success" id="btn-menambahkan">Menambahkan</button>
                    </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {


        $('form#formdibayar').submitAjax({
            pre: () => {
                $('button#btn-menambahkan').hide();
            },
            pasca: () => {
                $('button#btn-menambahkan').show();

            },

            success: (response, status) => {
                $("#modalForm").modal('hide');
                $("table#table-pembayaran").DataTable().ajax.reload();
            },

            error: (xhr, status) => {
                alert('Maaf data salah');
            }

        });


        $('button#btn-menambahkan').on('click', function() {
            $('form#formdibayar').submit();

        });


        $('button#btn-tambah').on('click', function() {
            $('#modalForm').modal('show');
            $('form#formdibayar').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-pembayaran').on('click', '.btn-light', function() {
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/pembayaran/${id}`).done((e) => {
                $('input[name=id]').val(e.id);
                $('input[name=tgl]').val(e.tgl);
                $('input[name=tagihan]').val(e.tagihan);
                $('input[name=dibayar]').val(e.dibayar);
                $('input[name=nama_pembayar]').val(e.nama_pembayar);
                $('input[name=metodebayar_id]').val(e.metodebayar_id);
                $('input[name=pengguna_id]').val(e.pengguna_id);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-pembayaran').on('click', '.btn-danger', function() {
            let konfirmasi = confirm('yakin hapus data?');
            if (konfirmasi === true) {
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/pembayaran`, {
                    id: _id,
                    _method: 'delete'
                }).done(function(e) {
                    $('table#table-pembayaran').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-pembayaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url('pembayaran/all')?>",
                method: 'GET'
            },
            columns: [{
                    data: 'id',
                    sortable: false,
                    searchable: false,
                    render: (data, type, row, meta) => {
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                {
                    data: 'tgl'
                },
                {
                    data: 'tagihan'
                },
                {
                    data: 'dibayar'
                },
                {
                    data: 'nama_pembayar'
                },
                {
                    data: 'metodebayar_id'
                },
                {
                    data: 'pengguna_id'
                },
                {
                    data: 'id',
                    render: (data, type, meta, row) => {
                        var btnEdit =
                            `<button class='btn btn-light' data-id='${data}'> Edit</button>`;
                        var btnHapus =
                            `<button class = 'btn btn-danger 'data-id='${data}'> Hapus </button>`;
                        return btnEdit + btnHapus;
                    }

                },
            ]
        });
    });
    </script>