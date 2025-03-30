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
                    <h2 class="page-title">Presensi</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">

                    <div class="btn-list">
                        <a href="#" class="btn bg-transparent border border-secondary text-dark" data-bs-toggle="modal" data-bs-target="#report">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-report"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" /><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" /><path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8 11h4" /><path d="M8 15h3" /></svg>
                            Rekap Single
                        </a><a href="#" class="btn bg-transparent border border-secondary text-dark" data-bs-toggle="modal" data-bs-target="#reportMonth">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-report"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" /><path d="M18 14v4h4" /><path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" /><path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8 11h4" /><path d="M8 15h3" /></svg>
                            Rekap Bulan
                        </a>
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
                            <form action="{{ route('panel.attendance') }}" method="get">
                                <div class="row align-items-end">
                                    <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                        <label for="" class="col-form-label">Tanggal</label>
                                        <input type="text" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}" autocomplete="off" readonly>
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
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($attendances->count() > 0)
                                    @foreach ($attendances as $index => $item)
                                    <tr>
                                        <td>{{ ($attendances->currentpage()-1) * $attendances->perpage() + $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('panel.attendance.show', $item->id) }}">{{ $item->employee->name }}</a>
                                        </td>
                                        <td>
                                            @if ($item->checkin_time !== '00:00:00')
                                            {{ \Carbon\Carbon::parse($item->checkin_time)->format('H:i') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if (!in_array($item->checkout_time, ['00:00:00', null]))
                                            {{ \Carbon\Carbon::parse($item->checkout_time)->format('H:i') }}
                                            @endif
                                        </td>
                                        <td>{{ $item->status }}</td>
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
                        @if ($attendances->total() > $attendances->perPage())
                        <div class="px-3 mt-3">
                            {{ $attendances->withQueryString()->links() }}
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
                <h5 class="modal-title">Presensi</h5>
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
                    <label class="form-label">Status</label>
                    <select name="status" id="" class="form-select">
                        <option value="">Pilih</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Tanpa Keterangan">Tanpa Keterangan</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Keterangan <small>(opsional)</small></label>
                    <input type="text" class="form-control" name="note">
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
<div class="modal modal-blur fade" id="report" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rekap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Pegawai</label>
                    <select name="employee-report" id="" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($employees as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <input type="text" class="form-control" name="period" autocomplete="off" maxlength="7" readonly>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save-report" type="button" class="btn btn-primary ms-auto">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                    Unduh
                </button>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="reportMonth" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rekap Bulanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Periode</label>
                    <input type="text" class="form-control" name="period" autocomplete="off" maxlength="7" readonly>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save-report" type="button" class="btn btn-primary ms-auto">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                    Unduh
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dateInput = document.querySelector('input[name="date"]');
    const employeeInput = document.querySelector('select[name="employee"]');
    const statusInput = document.querySelector('select[name="status"]');
    const noteInput = document.querySelector('input[name="note"]');
    const saveButton = document.getElementById('save');
    const closeButton = document.querySelector('button.btn-close');
    const employeeReportInput = document.querySelector('select[name="employee-report"]');
    const periodInput = document.querySelector('input[name="period"]');
    const saveReportButton = document.getElementById('save-report');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
    const downloadIcon = '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>';
    const csrfToken = '{{ csrf_token() }}';

    new Datepicker(dateInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxView: 2,
        maxDate: new Date(),
    });

    new Datepicker(periodInput, {
        autohide: true,
        format: 'mm-yyyy',
        maxView: 1,
        pickLevel: 1,
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
        statusInput.setAttribute('disabled', '');
        noteInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        closeButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        employeeInput.removeAttribute('disabled');
        statusInput.removeAttribute('disabled');
        noteInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        closeButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.employee_id) {
            employeeInput.classList.add('is-invalid');
            employeeInput.nextElementSibling.textContent = errors.employee_id[0];
        }
        if (errors.status) {
            statusInput.classList.add('is-invalid');
            statusInput.nextElementSibling.textContent = errors.status[0];
        }
        if (errors.note) {
            noteInput.classList.add('is-invalid');
            noteInput.nextElementSibling.textContent = errors.note[0];
        }
    };

    const clearErrors = () => {
        employeeInput.classList.remove('is-invalid');
        employeeInput.nextElementSibling.textContent = '';
        statusInput.classList.remove('is-invalid');
        statusInput.nextElementSibling.textContent = '';
        noteInput.classList.remove('is-invalid');
        noteInput.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const body = {
            employee_id: employeeInput.value,
            status: statusInput.value,
            note: noteInput.value,
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

        const response = await fetch(`${window.location.origin}/panel/presensi`, options);
        const result = await response.json();
        return result;
    };

    saveReportButton.addEventListener('click', async () => {
        clearReportErrors();
        disabledReportElement();

        const response = await saveReport();

        if (response.errors) {
            showReportErrors(response.errors);
        }

        enabledReportElement();
    })

    const disabledReportElement = () => {
        employeeReportInput.setAttribute('disabled', '');
        periodInput.setAttribute('disabled', '');
        saveReportButton.setAttribute('disabled', '');
        saveReportButton.innerHTML = `${spinnerIcon} Loading`;
    }

    const enabledReportElement = () => {
        employeeReportInput.removeAttribute('disabled');
        periodInput.removeAttribute('disabled');
        saveReportButton.removeAttribute('disabled');
        saveReportButton.innerHTML = `${downloadIcon} Unduh`;
    }

    const showReportErrors = (errors) => {
        if (errors.period) {
            periodInput.classList.add('is-invalid');
            periodInput.nextElementSibling.nextElementSibling.textContent = errors.period[0];
        }
    }

    const clearReportErrors = () => {
        periodInput.classList.remove('is-invalid');
        periodInput.nextElementSibling.nextElementSibling.textContent = '';
    }

    const saveReport = async () => {
        const body = {
            employee_id: employeeReportInput.value,
            period: periodInput.value
        };
        const encodedBody = new URLSearchParams(body);
        const options = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: encodedBody
        }
        const response = await fetch(`${window.location.origin}/panel/presensi/rekap`, options);
        const responseClone = response.clone();
        const blob = await response.blob();

        let result = {};

        if (blob.type === 'application/json') {
            result = await responseClone.json();
        } else {
            const contentDisposition = await response.headers.get('Content-Disposition');
            const filenameMatch = contentDisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);
            const filename = filenameMatch[1].replace(/['"]/g, '');
            const link = document.createElement('a');
            const downloadUrl = window.URL.createObjectURL(blob);
            link.href = downloadUrl;
            link.download = filename;

            // Append to html link element page
            document.body.appendChild(link);

            // Start download
            link.click();

            // Clean up and remove the link
            link.parentNode.removeChild(link);
            window.URL.revokeObjectURL(downloadUrl);
        }

        return result;
    }
</script>
@endpush
