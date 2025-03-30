@extends('layouts.panel.main')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row">
                <div class="col">
                    <h2 class="page-title">Dashboard</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">User</div>
                            </div>
                            <div class="h1 mb-3">{{ $totalUser }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">Pegawai</div>
                            </div>
                            <div class="h1 mb-3">{{ $totalEmployee }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
@endsection
