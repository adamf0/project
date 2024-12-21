@extends('template.index')
 
@section('page-title')
    <x-page-title title="Dokumen Induk">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('penilaian.index') }}">Dokumen Induk</a></li>
            <li class="breadcrumb-item active">Ubah</li>
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
                            <form action="{{ route('dokumenInduk.update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" class="@error('id') is-invalid @enderror" value="{{ old('id',$penilaian->GetId()) }}">
                                <div class="row">
                                    <div class="col-12">
                                        <x-input-text title="Nama Berkas" name="nama_berkas" default="{{ old('nama_berkas',$penilaian->GetNamaBerkas()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-input-text title="Url" name="url" default="{{ old('url',$penilaian->GetUrl()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <label>File</label>
                                        <input type="file" name="file" class=" form-control file" value="" autocomplete="off" accept="application/pdf">
                                        @error('file')
                                            <span class="text-danger">{{ $message }}</span><br>
                                        @enderror
                                        Max Ukuran File Upload: <b>5Mb</b><br>
                                        Tipe File: <b>PDF</b><br>
                                        File: {{ $penilaian?->GetFile() }}
                                    </div>
                                </div>
                                <input type="submit" name="submit" class="btn btn-primary" value="submit">
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

        });
    </script>
@endpush