@extends('template.index')
 
@section('page-title')
    <x-page-title title="Dashboard">
        <!-- <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Lembaga Akreditasi</li>
            </ol>
        </nav> -->
    </x-page-title>
@stop

@section('content')
<style>
    .scrollme {
        overflow-x: auto;
    }
</style>
<div class="row">
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-4 col-xs-12">
        <div class="card info-card sales-card" style="min-height: calc(100% - 30px);">
            <div class="card-body">
                <h5 class="card-title">Total</h5>
                <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-files"></i>
                    </div>
                    <div class="ps-3">
                        <h6>0</h6>
                        <!-- <span class="text-success small pt-1 fw-bold">13%</span> <span class="text-muted small pt-3 ps-1">increase</span> -->
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
            var CSRF_TOKEN      = $('meta[name="csrf-token"]').attr('content');

        });
    </script>
@endpush