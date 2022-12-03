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
    <table id='table-pemesanan' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kamar  </th>
                <th>Tanggal Mulai </th>
                <th>Tanggal Selesai </th>
                <th>Pemesanan Status </th>
                <th>Tamu </th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<div id="modalForm" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pemesanan </h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formpesan" method="post" action="<?=base_url('pemesanan') ?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="form-label">Kamar </label>
                        <input type="text" name="kamar_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai</label>
                        <input type="date" name="tgl_selesai" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pemesanan Status</label>
                        <input type="text" name="pemesananstatus_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tamu </label>
                        <input type="text" name="tamu_id" class="form-control">
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


        $('form#formpesan').submitAjax({
            pre: () => {
                $('button#btn-menambahkan').hide();
            },
            pasca: () => {
                $('button#btn-menambahkan').show();

            },

            success: (response, status) => {
                $("#modalForm").modal('hide');
                $("table#table-pemesanan").DataTable().ajax.reload();
            },

            error: (xhr, status) => {
                alert('Maaf data salah');
            }

        });


        $('button#btn-menambahkan').on('click', function() {
            $('form#formpesan').submit();

        });


        $('button#btn-tambah').on('click', function() {
            $('#modalForm').modal('show');
            $('form#formpesan').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-pemesanan').on('click', '.btn-light', function() {
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/pemesana/${id}`).done((e) => {
                $('input[name=id]').val(e.id);
                $('input[name=kamar_id]').val(e.kamar_id);
                $('input[name=tgl_mulai]').val(e.tgl_mulai);
                $('input[name=tgl_selesai]').val(e.tgl_selesai);
                $('input[name=pemesananstatus_id]').val(e.pemesananstatus_id);
                $('input[name=tamu_id]').val(e.tamu_id);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-pemesanan').on('click', '.btn-danger', function() {
            let konfirmasi = confirm('yakin hapus data?');
            if (konfirmasi === true) {
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/pemesanan`, {
                    id: _id,
                    _method: 'delete'
                }).done(function(e) {
                    $('table#table-pemesanan').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-pemesanan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url('pemesanan/all')?>",
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
                    data: 'kamar_id'
                },
                {
                    data: 'tgl_mulai'
                },
                {
                    data: 'tgl_selesai'
                },
                {
                    data: 'pemesananstatus_id'
                },
                {
                    data: 'tamu_id'
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