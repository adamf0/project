@extends('template.index')
 
@section('page-title')
    <x-page-title title="Matriks">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Matriks</li>
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
                @if(Utility::hasAdmin() || Utility::hasProdi())
                <a href="{{ route('penilaian.create') }}" class="btn btn-primary">Tambah</a>
                @endif

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
@stop

@push('scripts')
    <script type="text/javascript" src="{{ Utility::loadAsset('my.js') }}"></script>
    <script>
        $(document).ready(function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            
            const level = `{{Session::get('level')}}`;
            let table = eTable({
                url: `{{ route('datatable.Penilaian.index') }}?level=${level}`,
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
        });
    </script>
@endpush