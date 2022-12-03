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
    <table id='table-kamardipesan' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Pemesanan </th>
                <th>Kamar </th>
                <th>Tarif </th>
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
                <h4 class="modal-title">Kamar Dipesan</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formkamardipesankamu" method="post" action="<?=base_url('kamardipesan') ?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="form-label">Pemesanan</label>
                        <input type="text" name="pemesanan_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kamar</label>
                        <input type="text" name="kamar_id" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarif</label>
                        <input type="date" name="tarif" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pengguna</label>
                        <input type="date" name="pengguna_id" class="form-control">
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

    
        $('form#formkamardipesankamu').submitAjax({
            pre: () => {
                $('button#btn-menambahkan').hide();
            },
            pasca: () => {
                $('button#btn-menambahkan').show();

            },

            success: (response, status) => {
                $("#modalForm").modal('hide');
                $("table#table-kamardipesan").DataTable().ajax.reload();
            },

            error: (xhr, status) => {
                alert('Maaf data salah');
            }

        });


        $('button#btn-menambahkan').on('click', function() {
            $('form#formkamardipesankamu').submit();

        });


        $('button#btn-tambah').on('click', function() {
            $('#modalForm').modal('show');
            $('form#formkamardipesankamu').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-kamardipesan').on('click', '.btn-light', function() {
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/kamardipesan/${id}`).done((e) => {
                $('input[name=id]').val(e.id);
                $('input[name=pemesanan_id]').val(e.pemesanan_id);
                $('input[name=kamar_id]').val(e.kamar_id);
                $('input[name=tarif]').val(e.tarif);
                $('input[name=pengguna_id]').val(e.pengguna_id);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-kamardipesan').on('click', '.btn-danger', function() {
            let konfirmasi = confirm('yakin hapus data?');
            if (konfirmasi === true) {
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/kamardipesan`, {
                    id: _id,
                    _method: 'delete'
                }).done(function(e) {
                    $('table#table-kamardipesan').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-kamardipesan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url('kamardipesan/all')?>",
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
                    data: 'pemesanan_id'
                },
                {
                    data: 'kamar_id'
                },
                {
                    data: 'tarif'
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