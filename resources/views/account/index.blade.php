@extends('template.index')
 
@section('page-title')
    <x-page-title title="Account">
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.index') }}">Account</a></li>
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
                            <form action="{{ route('account.update') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <x-input-text title="Nama" name="nama" default="{{ old('nama',$account->GetNama()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-input-text title="Username" name="username" default="{{ old('username',$account->GetUsername()) }}"/>
                                    </div>
                                    <div class="col-12">
                                        <x-input-pass title="Password" name="password" default="{{ old('password',$account->GetPassword()) }}"/>
                                        <small>*kosongkan jika tidak ingin ubah password</small>
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