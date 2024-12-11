@extends('template.index')
 
@section('page-title')
    <x-page-title title="User">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
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
                            <form action="{{ route('user.update') }}" method="post">
                                @csrf
                                <input type="hidden" name="id" class="@error('id') is-invalid @enderror" value="{{ old('id',$user->GetId()) }}">
                                <div class="row">
                                    <div class="col-12">
                                        <x-input-text title="Nama" name="nama" default="{{ old('nama',$user->GetNama()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-input-text title="Username" name="username" default="{{ old('username',$user->GetUsername()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-input-pass title="Password" name="password" default="{{ old('password',$user->GetPassword()) }}"/>
                                        <small>*kosongkan jika tidak ingin ubah password</small>
                                    </div>
                                    <div class="col-12">
                                        <x-input-select title="Level" name="level" class="level"></x-input-select>
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
            const level = [
                {
                    "id":"guest",
                    "text":"guest",
                },
                {
                    "id":"admin",
                    "text":"admin",
                },
                {
                    "id":"prodi",
                    "text":"prodi",
                },
            ]
            load_dropdown('.level',level,null,"{{ old('level',$user->GetLevel()) }}",'-- Pilih Level --');
        });
    </script>
@endpush