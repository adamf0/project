@extends('template.index')
 
@section('page-title')
    <x-page-title title="Matriks">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('matriks.index') }}">Matriks</a></li>
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
                            <form action="{{ route('matriks.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" class="@error('id') is-invalid @enderror" value="{{ old('id',$matriks->GetId()) }}">
                                <div class="row">
                                    <div class="col-12">
                                        <x-input-text title="Nama" name="nama" default="{{ old('nama',$matriks->GetNama()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-text title="Deskripsi" name="deskripsi" default="{{ old('deskripsi',$matriks->GetDeskripsi()) }}"/>
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
    <script>
        $(document).ready(function () {
        
        });
    </script>
@endpush