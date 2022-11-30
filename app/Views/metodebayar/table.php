        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            rel="stylesheet" crosorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js"
            ></script>
        <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet"> 
        <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

            <div class="container">
                <button class="float-end btn btn-sm btn-primary" id="btn-tambah">Tambah</button>
                <table id='table-metodebayar' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Metode</th>
                            <th>Aktif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Metode Bayar</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formMetode" method="post" action="<?=base_url('metodebayar') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Metode Bayar</label>
                                <select name="metode" class="form-control">
                                    <option>Metode Bayar</option>
                                    <option value="Tr">Transfer</option>
                                    <option value="Tu">Tunai</option>
                                    <option value="De">Debit Card</option>
                                    <option value="Ca">Credit Card</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status Aktif</label>
                                <select name="aktif" class="form-control">
                                    <option>Status Aktif</option>
                                    <option value="Y">Aktif</option>
                                    <option value="T">Tidak Aktif</option>
                                </select>
                            </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn-menambahkan" >Menambahkan</button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    $(document).ready(function(){
        
        
        $('form#formMetode').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-metodebayar").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });


        $('button#btn-menambahkan').on('click' , function(){
            $('form#formMetode').submit();

        });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formMetode').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-metodebayar').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/metodebayar/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=metode]').val(e.metode);
                $('input[name=aktif]').val(e.aktif);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-metodebayar').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/metodebayar`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-metodebayar').DataTable().ajax.reload();
                });
            }
        });


        $('table#table-metodebayar').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('metodebayar/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id',sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                { data: 'metode', 
                render: (data, type, meta, row)=>{
                if( data === 'Tr' ){
                    return 'Transfer';
                }else if( data === 'Tu' ){
                    return 'Tunai';
                }
                else if( data === 'De' ){
                    return 'Debit Card';
                }
                else if( data === 'Ca' ){
                    return 'Credit Card';
                }
                return data;
                }
                },
                { data: 'aktif', 
                render: (data, type, meta, row)=>{
                if( data === 'Y' ){
                    return 'Aktif';
                }else if( data === 'T' ){
                    return 'Tidak Aktif';
                }
                return data;
              }
            },
                {data: 'id',
                    render: (data,type,meta,row)=>{
                        var btnEdit     = `<button class='btn btn-light' data-id='${data}'> Edit</button>`;
                        var btnHapus    = `<button class = 'btn btn-danger 'data-id='${data}'> Hapus </button>`;
                        return btnEdit + btnHapus;
                    }

                },
            ]
        });
    });
</script>