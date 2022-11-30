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
                <table id='table-pengguna' class="datatable table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Depan</th>
                            <th>Nama Belakang</th>
                            <th>Gender </th>
                            <th>Alamat </th>
                            <th>Kota </th>
                            <th>Tanggal Lahir</th>
                            <th>No telp </th>
                            <th>No Hp </th>
                            <th>Email </th>
                            <th>Level</th>
                            <th>Foto</th>
                            <th>Sandi</th>
                            <th>Token Reset</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div id="modalForm" class="modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Data Pengguna</h4>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formPengguna" method="post" action="<?=base_url('pengguna') ?>">
                            <input type="hidden" name="id" />
                            <input type="hidden" name="_method" />
                            <div class="mb-3">
                                <label class="form-label">Nama Depan</label>
                                <input type="text" name="nama_depan" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Belakang</label>
                                <input type="text" name="nama_belakang" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control">
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-Laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" name="alamat" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kota</label>
                                <input type="text" name="kota" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lhr" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Telp</label>
                                <input type="text" name="notelp" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No Hp</label>
                                <input type="text" name="nohp" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Level</label>
                                <select name="gender" class="form-control">
                                    <option>Pilih Level</option>
                                    <option value="M">Meneger</option>
                                    <option value="A">Administrasi</option>
                                    <option value="R">Resepsionis</option>
                                    <option value="B">Room Boy</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">foto</label>
                                <input type="text" name="foto" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sandi</label>
                                <input type="password" name="sandi" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Token Reset</label>
                                <input type="text" name="token_reset" class="form-control">
                            </div>

                        <div class="modal-footer">
                            <button class="btn btn-success" id="btn-menambahkan" >Menambahkan</button>
                        </div>
                    </div>
                </div>
            </div>

<script>
    $(document).ready(function(){
        
        
        $('form#formPengguna').submitAjax({
        pre:()=>{
            $('button#btn-menambahkan').hide();
        },
        pasca:()=>{
            $('button#btn-menambahkan').show();

        },

        success:(response, status)=>{
            $("#modalForm").modal('hide');
            $("table#table-pengguna").DataTable().ajax.reload();
        },

        error:(xhr, status)=>{
            alert('Maaf data salah');
        }

        });


        $('button#btn-menambahkan').on('click' , function(){
            $('form#formPengguna').submit();

        });


        $('button#btn-tambah').on('click' , function(){
            $('#modalForm').modal('show');
            $('form#formPengguna').trigger('reset');
            $('input[name=_method]').val('');
        });

        $('table#table-pengguna').on('click', '.btn-light', function (){
            let id = $(this).data('id');
            let baseurl = "<?=base_url()?>";
            $.get(`${baseurl}/pengguna/${id}`).done((e)=>{
                $('input[name=id]').val(e.id);
                $('input[name=nama_depan]').val(e.nama_depan);
                $('input[name=nama_belakang]').val(e.nama_belakang);
                $('input[name=gender]').val(e.gender);
                $('input[name=alamat]').val(e.alamat);
                $('input[name=kota]').val(e.kota);
                $('input[name=tgl_lhr]').val(e.tgl_lhr);
                $('input[name=notelp]').val(e.notelp);
                $('input[name=nohp]').val(e.nohp);
                $('input[name=email]').val(e.email);
                $('input[name=level]').val(e.level);
                $('input[name=foto]').val(e.foto);
                $('input[name=sandi]').val(e.sandi);
                $('input[name=token_reset]').val(e.token_reset);
                $('#modalForm').modal('show');
                $('input[name=_method]').val('patch');

            });
        });

        $('table#table-pengguna').on('click', '.btn-danger', function (){
            let konfirmasi = confirm ('yakin hapus data?');
            if(konfirmasi === true){
                let _id = $(this).data('id');
                let baseurl = "<?=base_url()?>";


                $.post(`${baseurl}/pengguna`, {id:_id, _method:'delete'}).done(function(e){
                    $('table#table-pengguna').DataTable().ajax.reload();
                });
            }
        });

        
        $('table#table-pengguna').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "<?=base_url('pengguna/all')?>",
                method: 'GET'
            },
            columns:[
                {data: 'id', sortable:false, searchable:false,
                    render: (data,type,row,meta)=>{
                        return meta.settings._iDisplayStart + meta.row + 1;
                    }
                },
                {data: 'nama_depan'},
                {data: 'nama_belakang'},
                { data: 'gender', 
                render: (data, type, meta, row)=>{
                if( data === 'L' ){
                    return 'Laki-Laki';
                }else if( data === 'P' ){
                    return 'Perempuan';
                }
                return data;
                 }
                },
                {data: 'alamat'},
                {data: 'kota'},
                {data: 'tgl_lhr'},
                {data: 'notelp'},
                {data: 'nohp'},
                {data: 'email'},
                { data: 'level', 
                render: (data, type, meta, row)=>{
                if( data === 'M' ){
                    return 'Meneger';
                }else if( data === 'A' ){
                    return 'Administrasi';
                }
                else if( data === 'R' ){
                    return 'Resepsionis';
                }
                else if( data === 'B' ){
                    return 'Room Boy';
                }
                return data;
                }
                },
                {data: 'foto'},
                {data: 'sandi'},
                {data: 'token_reset'},
                {data: 'id',
                    render: (data,type,meta,row)=>{
                        var btnEdit     = `<button class = 'btn btn-light' data-id='${data}'> Edit</button>`;
                        var btnHapus    = `<button class = 'btn btn-danger 'data-id='${data}'> Hapus </button>`;
                        return btnEdit + btnHapus;
                    }

                },
            ]
        });
    });
</script>