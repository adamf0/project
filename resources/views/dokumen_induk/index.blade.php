@extends('template.index')
 
@section('page-title')
    <x-page-title title="Dokumen Induk">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dokumen Induk</li>
            </ol>
        </nav>
    </x-page-title>
@stop

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                {{ Utility::showNotif() }}
            </div>
            <!-- <div class="col-12">
                <div class="card">
                    <div class="card-body row">
                        <div class="col-12">
                            <label>Tahun</label>
                            <input type="text" name="tahun_filter" class=" form-control tahun_filter" value="{{date('Y')}}" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary btn-filter">Filter</button>
                        </div>
                    </div>
                </div>
            </div> -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary btn-add">Tambah</button>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table id="tb" class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Berkas</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-lg fade" id="modalAdd" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row formInputAdd gap-2">
                        <div class="col-12">
                            <label>Nama Berkas</label>
                            <input type="text" name="nama_berkas" class=" form-control nama_berkas" value="" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label>Url <small>(opsional)</small></label>
                            <input type="text" name="url" class=" form-control url" value="" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label>File</label>
                            <input type="file" name="file" class=" form-control file" value="" autocomplete="off" accept="application/pdf">
                            Max Ukuran File Upload: <b>5Mb</b><br>
                            Tipe File: <b>PDF</b><br>
                        </div>
                    <div class="col-12">
                        <input type="button" class="btn btn-primary btnSave" value="Simpan" />
                    </div>
                </div>
                <div class="row formLoaderAdd justify-content-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('scripts')
    <script type="text/javascript" src="{{ Utility::loadAsset('my.js') }}"></script>
    <script>
        $(document).ready(function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            const level = `{{Session::get('level')}}`;
            url = null;
            tahun = null;
            nama_berkas = null;

            let modalAdd = new bootstrap.Modal(document.getElementById('modalAdd'));
            let btnSave = $('.btnSave');
            let formInputAdd = $('.formInputAdd');
            let formLoaderAdd = $('.formLoaderAdd');

            modalAdd._element.addEventListener('hidden.bs.modal', function(event) {
                idPenelitianInternal = null;
            });

            let table = eTable({
                url: `{{ route('datatable.DokumenInduk.index') }}?level=${level}&tahun={{date('Y')}}`,
            }, [
                {
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    sWidth:'3%'
                },
                {
                    data: 'berkas_render', 
                    name: 'berkas_render',
                    render: function ( data, type, row, meta ) {
                        return data;
                    }
                },
                {
                    data: 'action_render', 
                    name: 'action_render',
                    render: function ( data, type, row, meta ) {
                        return data;
                    }
                },
            ]);

            // $('.btn-filter').click(function(e) {
            //     e.preventDefault();
            //     let tahun = $('.tahun_filter').val();

            //     console.log(tahun)
            //     table.ajax.url(`{{ route('datatable.DokumenInduk.index') }}?level=${level}&tahun=${tahun}`).load();
            // });
            btnSave.click(function(e) {
                e.preventDefault();
                const fileInput =  $('.file')[0]?.files[0] || null;
                let error_file = false;

                if (fileInput!=null || fileInput!=undefined) { //gagal cek ukuran file
                    const fileSize = fileInput.size;
                    const fileMb = fileSize / 1024 ** 2;
                    console.log(`fileMb: ${fileMb}`)
                    
                    if(fileMb>5){
                        error_file = true;
                        alert("file tidak boleh lebih dari 5MB")
                    } else{
                        error_file = false;
                    }
                }

                if(!error_file){
                    let dataForm = new FormData();
                    dataForm.append("nama_berkas", $(".nama_berkas").val());
                    dataForm.append("url", $(".url").val());
                    dataForm.append('file', fileInput);
                    dataForm.append("tahun", '');

                    formInputAdd.hide();
                    formLoaderAdd.show();
                    ERequest(
                        new Url(`{{route('api.DokumenInduk.create')}}`, "post", {
                            'X-CSRF-TOKEN': CSRF_TOKEN
                        }),
                        dataForm,
                        function(response) {
                            console.log(response);
                            formInputAdd.show();
                            formLoaderAdd.hide();

                            table.draw();
                            alert(response.message);
                        },
                        function(xhr, status, error) {
                            formInputAdd.show();
                            formLoaderAdd.hide();
                            // modalAddReviewer.hide();
                            handleAjaxError(xhr, status, error);
                        }
                    );

                    table.draw();
                }
            });

            $('.btn-add').click(function(e) {
                e.preventDefault();

                formInputAdd.show();
                formLoaderAdd.hide();
                modalAdd.show();
            });
        });
    </script>
@endpush