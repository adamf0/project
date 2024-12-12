@extends('template.index')
 
@section('page-title')
    <x-page-title title="{{Session::get('level')=='guest'? 'Dashboard':'Penilaian'}}">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">@if(Session::get('level')=="guest")  @else Penilaian @endif</li>
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
            <div class="col-12">
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
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="tb" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Matriks</th>
                                        <th>Berkas</th>
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
                            <x-input-select title="Matriks" name="matriks" class="matriks"></x-input-select>
                        </div>
                        <div class="col-12">
                            <label>Nama Berkas</label>
                            <input type="text" name="nama_berkas" class=" form-control nama_berkas" value="" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label>Url</label>
                            <input type="text" name="url" class=" form-control url" value="" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label>Tahun</label>
                            <input type="text" name="tahun" class=" form-control tahun" value="" autocomplete="off">
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
            matriks = null;
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
                url: `{{ route('datatable.Penilaian.index') }}?level=${level}&tahun={{date('Y')}}`,
            }, [
                {
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    sWidth:'3%'
                },
                {
                    data: 'nama_matriks', 
                    name: 'nama_matriks',
                    render: function ( data, type, row, meta ) {
                        return data;
                    }
                },
                {
                    data: 'berkas_render', 
                    name: 'berkas_render',
                    render: function ( data, type, row, meta ) {
                        return data;
                    }
                },
            ]);
            load_dropdown('.matriks',null,`{{ route('select2.Matriks.List') }}`,null,'-- Pilih Matriks --');

            $(".matriks").on('select2:select', async function(e) {
                matriks = $(this).val();
            });

            $('.btn-filter').click(function(e) {
                e.preventDefault();
                let tahun = $('.tahun_filter').val();

                console.log(tahun)
                table.ajax.url(`{{ route('datatable.Penilaian.index') }}?level=${level}&tahun=${tahun}`).load();
            });
            btnSave.click(function(e) {
                e.preventDefault();

                let dataForm = new FormData();
                dataForm.append("matriks", matriks);
                dataForm.append("nama_berkas", $(".nama_berkas").val());
                dataForm.append("url", $(".url").val());
                dataForm.append("tahun", $(".tahun").val());

                formInputAdd.hide();
                formLoaderAdd.show();
                ERequest(
                    new Url(`{{route('api.Penilaian.create')}}`, "post", {
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
            });

            $('#tb tbody').on('click', '.btn-add', function(e) {
                e.preventDefault();

                formInputAdd.show();
                formLoaderAdd.hide();
                modalAdd.show();
            });
        });
    </script>
@endpush