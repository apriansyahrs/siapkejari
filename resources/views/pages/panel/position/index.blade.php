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
                    <h2 class="page-title">Jabatan</h2>
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
                            <form action="{{ route('panel.position') }}" method="get">
                                <div class="row align-items-end">
                                    <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                        <label for="" class="col-form-label">Kata Kunci</label>
                                        <input type="text" class="form-control" name="keyword" value="{{ request()->keyword }}" placeholder="masukkan kata kunci..." autocomplete="off">
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
                                        <th>Nama</th>
                                        <th>Gaji Pokok <small>(RP)</small></th>
                                        <th>Shift</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($positions->count() > 0)
                                    @foreach ($positions as $index => $item)
                                    <tr>
                                        <td>{{ ($positions->currentpage()-1) * $positions->perpage() + $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('panel.position.show', $item->id) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ number_format($item->salary, 0, '', ',') }}</td>
                                        <td>
                                            @if ($item->is_enabled_shift)
                                            <span class="text-green">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                            </span>
                                            @else
                                            <span class="text-danger">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                            </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($item->is_active)
                                            <span class="badge bg-success-lt">Aktif</span>
                                            @else
                                            <span class="badge bg-secondary-lt">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">Tidak ada data</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($positions->total() > $positions->perPage())
                        <div class="px-3 mt-3">
                            {{ $positions->withQueryString()->links() }}
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
                <h5 class="modal-title">Jabatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text" class="form-control" name="name">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gaji Pokok</label>
                    <input type="text" class="form-control" name="salary">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label class="form-label">Shift</label>
                        <div class="form-selec,tgroup-boxes row">
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="shift" value="1" class="form-selectgroup-input">
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                        <span class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </span>
                                        <span class="form-selectgroup-label-content">
                                            <span class="form-selectgroup-title strong mb-1">Aktif</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="shift" value="0" class="form-selectgroup-input">
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                        <span class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </span>
                                        <span class="form-selectgroup-label-content">
                                            <span class="form-selectgroup-title strong mb-1">Tidak Aktif</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="invalid-feedback d-block"></div>
                    </div>
                </div>
                <div class="mb-3 d-none">
                    <label class="form-label">Jam Kerja</label>
                    <select name="working-hour" id="" class="form-select">
                        <option value="">Pilih</option>
                        @foreach ($workingHours as $item)
                        <option value="{{ $item->id }}">{{ $item->name }} {{ \Carbon\Carbon::parse($item->checkin_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->checkout_time)->format('H:i') }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <label class="form-label">Status</label>
                        <div class="form-selectgroup-boxes row">
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="status" value="1" class="form-selectgroup-input">
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                        <span class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </span>
                                        <span class="form-selectgroup-label-content">
                                            <span class="form-selectgroup-title strong mb-1">Aktif</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-selectgroup-item">
                                    <input type="radio" name="status" value="0" class="form-selectgroup-input">
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                        <span class="me-3">
                                            <span class="form-selectgroup-check"></span>
                                        </span>
                                        <span class="form-selectgroup-label-content">
                                            <span class="form-selectgroup-title strong mb-1">Tidak Aktif</span>
                                        </span>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="invalid-feedback d-block"></div>
                    </div>
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
    const nameInput = document.querySelector('input[name="name"]');
    const salaryInput = document.querySelector('input[name="salary"]');
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const workingHourInput = document.querySelector('select[name="working-hour"]');
    const shiftRadios = document.querySelectorAll('input[name="shift"]');
    const saveButton = document.getElementById('save');
    const closeButton = document.querySelector('button.btn-close');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
    const csrfToken = '{{ csrf_token() }}';

    shiftRadios.forEach((radio) => {
        radio.addEventListener('change', (e) => {
            if (e.target.value == 1) {
                workingHourInput.parentElement.classList.add('d-none');
            } else {
                workingHourInput.parentElement.classList.remove('d-none');
            }
        })
    })

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
        nameInput.setAttribute('disabled', '');
        salaryInput.setAttribute('disabled', '');
        statusRadios.forEach(item => {
            item.setAttribute('disabled', '');
        });
        workingHourInput.setAttribute('disabled', '');
        shiftRadios.forEach(item => {
            item.setAttribute('disabled', '');
        });
        saveButton.setAttribute('disabled', '');
        closeButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        nameInput.removeAttribute('disabled');
        salaryInput.removeAttribute('disabled');
        statusRadios.forEach(item => {
            item.removeAttribute('disabled');
        });
        workingHourInput.removeAttribute('disabled', '');
        shiftRadios.forEach(item => {
            item.removeAttribute('disabled');
        });
        saveButton.removeAttribute('disabled');
        closeButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.name) {
            nameInput.classList.add('is-invalid');
            nameInput.nextElementSibling.textContent = errors.name[0];
        }
        if (errors.salary) {
            salaryInput.classList.add('is-invalid');
            salaryInput.nextElementSibling.textContent = errors.salary[0];
        }
        if (errors.is_active) {
            statusRadios[0].parentElement.parentElement.parentElement.nextElementSibling.textContent = errors.is_active[0];
        }
        if (errors.working_hour_id) {
            workingHourInput.classList.add('is-invalid');
            workingHourInput.nextElementSibling.textContent = errors.working_hour_id[0];
        }
        if (errors.is_enabled_shift) {
            shiftRadios[0].parentElement.parentElement.parentElement.nextElementSibling.textContent = errors.is_enabled_shift[0];
        }
    };

    const clearErrors = () => {
        nameInput.classList.remove('is-invalid');
        nameInput.nextElementSibling.textContent = '';
        salaryInput.classList.remove('is-invalid');
        salaryInput.nextElementSibling.textContent = '';
        statusRadios[0].parentElement.parentElement.parentElement.nextElementSibling.textContent = '';
        workingHourInput.classList.remove('is-invalid');
        workingHourInput.nextElementSibling.textContent = '';
        shiftRadios[0].parentElement.parentElement.parentElement.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const body = {
            name: nameInput.value,
            salary: salaryInput.value,
            is_active: getSelectedValueRadio(statusRadios),
            working_hour_id: workingHourInput.value,
            is_enabled_shift: getSelectedValueRadio(shiftRadios),
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

        const response = await fetch(`${window.location.origin}/panel/jabatan`, options);
        const result = await response.json();
        return result;
    };

    const getSelectedValueRadio = (elements) => {
        let selectedValue = '';
        elements.forEach(radio => {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });
        return selectedValue;
    };
</script>
@endpush
