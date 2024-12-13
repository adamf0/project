@extends('template.index')
 
@section('page-title')
    <x-page-title title="Penilaian">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Penilaian</a></li>
            <li class="breadcrumb-item active">Tambah</li>
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
                        <div class="card-body">
                            <form action="{{ route('penilaian.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <x-input-select title="Matriks" name="matriks" class="matriks"></x-input-select>
                                    </div>
                                    <div class="col-12">
                                        <x-input-text title="Nama Berkas" name="nama_berkas" default="{{ old('nama_berkas') }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-input-text title="Url" name="url" default="{{ old('url') }}"/>
                                    </div>
                                    <div class="col-12">
                                        <label>File</label>
                                        <input type="file" name="file" class=" form-control file" value="" autocomplete="off" accept="application/pdf">
                                        @error('file')
                                            <span class="text-danger">{{ $message }}</span><br>
                                        @enderror
                                        Max Ukuran File Upload: <b>5Mb</b><br>
                                        Tipe File: <b>PDF</b><br>
                                    </div>
                                    <div class="col-12">
                                        <x-input-text title="Tahun" name="tahun" default="{{ old('tahun') }}"/>
                                    </div>
                                </div>
                                <input type="submit" name="submit" class="btn btn-primary mt-3" value="submit">
                            </form>
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
            load_dropdown('.matriks',null,`{{ route('select2.Matriks.List') }}`,"{{ old('matriks') }}",'-- Pilih Matriks --');
        });
    </script>
@endpush