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
    <table id='table-kamar' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Kamar Tipe </th>
                <th>Lantai </th>
                <th>Nomor </th>
                <th>Kamar Status </th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<div id="modalForm" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kamar</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formkamarnih" method="post" action="<?=base_url('kamar') ?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="form-label">Kamar Tipe</label>
                        <input type="text" name="kamartipe_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lantai</label>
                        <input type="text" name="lantai" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor</label>
                        <input type="date" name="nomor" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kamar Status</label>
                        <input type="date" name="kamarstatus_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <input type="text" name="deskripsi" class="form-control">
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


        $('form#formkamarnih').submitAjax({
            pre: () => {
                $('button#btn-menambahkan').hide();
            },
            pasca: () => {
                $('button#btn-menambahkan').show();

            },

            success: (response, status) => {
                $("#modalForm").modal('hide');
                $("table#table-kamar").DataTable().ajax.reload();
            },

            error: (xhr, status) => {
                alert('Maaf data salah');
            }

        });


        $('button#btn-menambahkan').on('click', function() {
            $('form#formkamarnih').submit();

        });


        $('button#btn-tambah').on('click', function() {
            $('#modalForm').modal('show');
            $('form#formkamarnih').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-kamar').on('click', '.btn-light', function() {
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/kamar/${id}`).done((e) => {
                $('input[name=id]').val(e.id);
                $('input[name=kamartipe_id]').val(e.kamartipe_id);
                $('input[name=lantai]').val(e.lantai);
                $('input[name=nomor]').val(e.nomor);
                $('input[name=kamarstatus_id]').val(e.kamarstatus_id);
                $('input[name=deskripsi]').val(e.deskripsi);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-kamar').on('click', '.btn-danger', function() {
            let konfirmasi = confirm('yakin hapus data?');
            if (konfirmasi === true) {
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/kamar`, {
                    id: _id,
                    _method: 'delete'
                }).done(function(e) {
                    $('table#table-kamar').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-kamar').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url('kamar/all')?>",
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
                    data: 'kamartipe_id'
                },
                {
                    data: 'lantai'
                },
                {
                    data: 'nomor'
                },
                {
                    data: 'kamarstatus_id'
                },
                {
                    data: 'deskripsi'
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