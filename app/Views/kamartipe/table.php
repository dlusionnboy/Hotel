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
    <table id='table-kamartipe' class="datatable table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Urutan </th>
                <th>Aktif</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>
</div>

<div id="modalForm" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Kamar Tipe</h4>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formkamartipe" method="post" action="<?=base_url('kamartipe') ?>">
                    <input type="hidden" name="id" />
                    <input type="hidden" name="_method" />
                    <div class="mb-3">
                        <label class="form-label">Tipe</label>
                        <select name="tipe" class="form-control">
                            <option>Tipe Yang Dipilih</option>
                            <option value="DE"> Deluxe </option>
                            <option value="SP"> Superior </option>
                            <option value="SU"> Suite </option>
                            <option value="MS"> Master Suite </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Urutan</label>
                        <input type="text" name="urutan" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Aktif</label>
                        <select name="aktif" class="form-control">
                            <option value="Y">Aktif</option>
                            <option value="T">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gambar</label>
                        <input type="varbinary" name="gambar" class="form-control">
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


        $('form#formkamartipe').submitAjax({
            pre: () => {
                $('button#btn-menambahkan').hide();
            },
            pasca: () => {
                $('button#btn-menambahkan').show();

            },

            success: (response, status) => {
                $("#modalForm").modal('hide');
                $("table#table-kamartipe").DataTable().ajax.reload();
            },

            error: (xhr, status) => {
                alert('Maaf data salah');
            }

        });


        $('button#btn-menambahkan').on('click', function() {
            $('form#formkamartipe').submit();

        });


        $('button#btn-tambah').on('click', function() {
            $('#modalForm').modal('show');
            $('form#formkamartipe').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-kamartipe').on('click', '.btn-light', function() {
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/kamartipe/${id}`).done((e) => {
                $('input[name=id]').val(e.id);
                $('input[name=tipe]').val(e.tipe);
                $('input[name=keterangan]').val(e.keterangan);
                $('input[name=urutan]').val(e.urutan);
                $('input[name=aktif]').val(e.aktif);
                $('input[name=gambar]').val(e.gambar);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-kamartipe').on('click', '.btn-danger', function() {
            let konfirmasi = confirm('yakin hapus data?');
            if (konfirmasi === true) {
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/kamartipe`, {
                    id: _id,
                    _method: 'delete'
                }).done(function(e) {
                    $('table#table-kamartipe').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-kamartipe').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url('kamartipe/all')?>",
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
                    data: 'tipe',
                    render: (data, type, meta, row) => {
                        if (data === 'DE') {
                            return 'Deluxe';
                        } else if (data === 'SP') {
                            return ' Superior ';
                        } else if (data === 'SU') {
                            return 'Suite';
                        } else if (data === 'MS') {
                            return 'Master Suite';
                        }
                        return data;
                    }
                },
                {
                    data: 'keterangan'
                },
                {
                    data: 'urutan'
                },
                {
                    data: 'aktif'
                },
                {
                    data: 'gambar'
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