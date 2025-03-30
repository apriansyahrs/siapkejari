@extends('layouts.panel.main')

@push('styles')
<style>
    .form-selectgroup-input:disabled+.form-selectgroup-label {
        background-color: #f6f8fb !important;
        cursor: default;
    }
    .form-selectgroup-input[disabled][checked]+.form-selectgroup-label {
        border-color: rgba(32, 107, 196, .5)
    }
    .form-selectgroup-input[disabled][checked]+.form-selectgroup-label .form-selectgroup-check {
        background-color: rgba(32, 107, 196, .5)
    }
    .form-selectgroup-boxes .form-selectgroup-input:disabled+.form-selectgroup-label .form-selectgroup-title {
        opacity: .7;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Jadwal Shift</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Tambah
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-block">
                            <form action="{{ route('panel.shift-schedule') }}" method="get">
                                <div class="row align-items-end">
                                    <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                        <label for="" class="col-form-label">Tanggal</label>
                                        <input type="text" class="form-control" name="date_filter" value="{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}" autocomplete="off" readonly>
                                    </div>
                                    <div class="col-12 col-lg-1">
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="#ffffff"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;">No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Shift</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($shiftSchedules->count() > 0)
                                    @foreach ($shiftSchedules as $index => $item)
                                    <tr>
                                        <td>{{ ($shiftSchedules->currentpage()-1) * $shiftSchedules->perpage() + $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('panel.shift-schedule.show', $item->id) }}">{{ $item->employee->name }}</a>
                                        </td>
                                        <td>{{ $item->shift->name }} {{ \Carbon\Carbon::parse($item->shift->checkin_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->shift->checkout_time)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->locale('id')->translatedFormat('d F Y') }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="4">Tidak ada data</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($shiftSchedules->total() > $shiftSchedules->perPage())
                        <div class="px-3 mt-3">
                            {{ $shiftSchedules->withQueryString()->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Jadwal Shift</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Pegawai</label>
                    <select name="employee" id="" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($employees as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Shift</label>
                    <select name="shift" id="" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($shifts as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} {{ \Carbon\Carbon::parse($item->checkin_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->checkout_time)->format('H:i') }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="text" class="form-control" name="date" maxlength="10" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save" type="button" class="btn btn-primary ms-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dateFilterInput = document.querySelector('input[name="date_filter"]');
    const employeeInput = document.querySelector('select[name="employee"]');
    const shiftInput = document.querySelector('select[name="shift"]');
    const dateInput = document.querySelector('input[name="date"]');
    const saveButton = document.getElementById('save');
    const closeButton = document.querySelector('button.btn-close');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
    const csrfToken = '{{ csrf_token() }}';

    new Datepicker(dateInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxView: 1,
        minDate: new Date(),
    });

    new Datepicker(dateFilterInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxView: 2,
        maxDate: new Date(),
    });

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return location.reload();
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        employeeInput.setAttribute('disabled', '');
        shiftInput.setAttribute('disabled', '');
        dateInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        closeButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        employeeInput.removeAttribute('disabled');
        shiftInput.removeAttribute('disabled');
        dateInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        closeButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.employee_id) {
            employeeInput.classList.add('is-invalid');
            employeeInput.nextElementSibling.textContent = errors.employee_id[0];
        }
        if (errors.shift_id) {
            shiftInput.classList.add('is-invalid');
            shiftInput.nextElementSibling.textContent = errors.shift_id[0];
        }
        if (errors.date) {
            dateInput.classList.add('is-invalid');
            dateInput.nextElementSibling.nextElementSibling.textContent = errors.date[0];
        }
    };

    const clearErrors = () => {
        employeeInput.classList.remove('is-invalid');
        employeeInput.nextElementSibling.textContent = '';
        shiftInput.classList.remove('is-invalid');
        shiftInput.nextElementSibling.textContent = '';
        dateInput.classList.remove('is-invalid');
        dateInput.nextElementSibling.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const body = {
            employee_id: employeeInput.value,
            shift_id: shiftInput.value,
            date: dateInput.value,
        };

        const encodedBody = new URLSearchParams(body);
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: encodedBody,
        };

        const response = await fetch(`${window.location.origin}/panel/jadwal-shift`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
