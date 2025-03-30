@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="page-title">Presensi</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-label">Nama Pegawai</label>
                            <p class="mb-2">{{ $attendance->employee->name }}</p>
                            @if ($attendance->status !== 'Hadir')
                            <label class="form-label">Tanggal</label>
                            <p class="mb-2">{{ \Carbon\Carbon::parse($attendance->checkin_date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                            @endif
                            <label class="form-label">Status</label>
                            <p class="mb-0">{{ $attendance->status }}</p>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Checkin</h3>
                        </div>
                        <div class="card-body">
                            <label for="" class="form-label">Jam</label>
                            <p class="mb-2">{{ \Carbon\Carbon::parse($attendance->checkin_time)->format('H:i') }}</p>
                            <label for="" class="form-label">Foto</label>
                            <img src="{{ Storage::url('attendances/'.$attendance->checkin_photo) }}" alt="" height="200" class="mb-2">
                            <label for="" class="form-label">Koordinat</label>
                            <div style="width: 100%">
                                <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=id&amp;q={{ $attendance->checkin_latitude }},{{ $attendance->checkin_longitude }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                    @if (
                        $attendance->checkout_date
                        && $attendance->checkout_time
                        && $attendance->checkout_photo
                        && $attendance->checkout_latitude
                        && $attendance->checkout_longitude
                    )
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Checkout</h3>
                        </div>
                        <div class="card-body">
                            <label for="" class="form-label">Jam</label>
                            <p class="mb-2">{{ \Carbon\Carbon::parse($attendance->checkout_time)->format('H:i') }}</p>
                            <label for="" class="form-label">Foto</label>
                            <img src="{{ Storage::disk('public')->url('attendances/'.$attendance->checkout_photo) }}" alt="" height="200" class="mb-2">
                            <label for="" class="form-label">Koordinat</label>
                            <div style="width: 100%">
                                <iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=300&amp;hl=id&amp;q={{ $attendance->checkout_latitude }},{{ $attendance->checkout_longitude }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
@endsection
