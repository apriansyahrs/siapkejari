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
                    <h2 class="page-title">Pegawai</h2>
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
                            <form action="{{ route('panel.employee') }}" method="get">
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
                                        <th>Email</th>
                                        <th>Jabatan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($employees->count() > 0)
                                    @foreach ($employees as $index => $item)
                                    <tr>
                                        <td>{{ ($employees->currentpage()-1) * $employees->perpage() + $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('panel.employee.show', $item->username) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->position->name }}</td>
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
                        @if ($employees->total() > $employees->perPage())
                        <div class="px-3 mt-3">
                            {{ $employees->withQueryString()->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
<div class="modal modal-blur fade modal-lg" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" maxlength="16">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="email">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="birth-place">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Tgl. Lahir</label>
                        <input type="text" class="form-control" name="birth-date" maxlength="10" autocomplete="off">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">Jabatan</label>
                        <select name="position" id="" class="form-select">
                            <option value="">Pilih</option>
                            @foreach ($positions as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Status Perkawinan</label>
                        <select name="marital-status" id="" class="form-select">
                            <option value="">Pilih</option>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">NPWP</label>
                        <input type="text" class="form-control" name="npwp">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No. HP</label>
                        <input type="text" class="form-control" name="phone-number">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-4">
                        <label class="form-label">No. BPJS</label>
                        <input type="text" class="form-control" name="health-insurance-number">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Kelas BPJS</label>
                        <select name="health-insurance" id="" class="form-select">
                            <option value="">Pilih</option>
                            @foreach ($healthInsurances as $item)
                            <option value="{{ $item->id }}">{{ $item->class }} &mdash; Rp{{ number_format($item->contribution, 0, '', ',') }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-4">
                        <label class="form-label">Jml. Tanggungan</label>
                        <input type="text" class="form-control" name="number-of-dependants">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label class="form-label">No. Rekening <small>(opsional)</small></label>
                        <input type="text" class="form-control" name="account-number">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="col-6">
                        <label class="form-label">No. Kontrak Kerja</label>
                        <input type="text" class="form-control" name="employment-contract">
                        <div class="invalid-feedback"></div>
                    </div>
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
    const nikInput = document.querySelector('input[name="nik"]');
    const usernameInput = document.querySelector('input[name="username"]');
    const nameInput = document.querySelector('input[name="name"]');
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const birthPlaceInput = document.querySelector('input[name="birth-place"]');
    const birthDateInput = document.querySelector('input[name="birth-date"]');
    const positionInput = document.querySelector('select[name="position"]');
    const maritalStatusInput = document.querySelector('select[name="marital-status"]');
    const npwpInput = document.querySelector('input[name="npwp"]');
    const phoneNumberInput = document.querySelector('input[name="phone-number"]');
    const healthInsuranceNumber = document.querySelector('input[name="health-insurance-number"]');
    const healthInsuranceInput = document.querySelector('select[name="health-insurance"]');
    const numberOfDependantsInput = document.querySelector('input[name="number-of-dependants"]');
    const accountNumberInput = document.querySelector('input[name="account-number"]');
    const employmentContractInput = document.querySelector('input[name="employment-contract"]');
    const statusRadios = document.querySelectorAll('input[name="status"]');
    const saveButton = document.getElementById('save');
    const closeButton = document.querySelector('button.btn-close');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
    const csrfToken = '{{ csrf_token() }}';
    const date = new Date();
    const seventeenYearsAgo = date.setFullYear(date.getFullYear() - 17);

    new Datepicker(birthDateInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxView: 2,
        maxDate: seventeenYearsAgo,
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
        nikInput.setAttribute('disabled', '');
        nameInput.setAttribute('disabled', '');
        usernameInput.setAttribute('disabled', '');
        emailInput.setAttribute('disabled', '');
        passwordInput.setAttribute('disabled', '');
        birthPlaceInput.setAttribute('disabled', '');
        birthDateInput.setAttribute('disabled', '');
        positionInput.setAttribute('disabled', '');
        maritalStatusInput.setAttribute('disabled', '');
        npwpInput.setAttribute('disabled', '');
        phoneNumberInput.setAttribute('disabled', '');
        healthInsuranceNumber.setAttribute('disabled', '');
        healthInsuranceInput.setAttribute('disabled', '');
        numberOfDependantsInput.setAttribute('disabled', '');
        accountNumberInput.setAttribute('disabled', '');
        employmentContractInput.setAttribute('disabled', '');
        statusRadios.forEach(item => {
            item.setAttribute('disabled', '');
        });
        saveButton.setAttribute('disabled', '');
        closeButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        nikInput.removeAttribute('disabled');
        nameInput.removeAttribute('disabled');
        usernameInput.removeAttribute('disabled');
        emailInput.removeAttribute('disabled');
        passwordInput.removeAttribute('disabled');
        birthPlaceInput.removeAttribute('disabled');
        birthDateInput.removeAttribute('disabled');
        positionInput.removeAttribute('disabled');
        maritalStatusInput.removeAttribute('disabled');
        npwpInput.removeAttribute('disabled');
        phoneNumberInput.removeAttribute('disabled');
        healthInsuranceNumber.removeAttribute('disabled');
        healthInsuranceInput.removeAttribute('disabled');
        numberOfDependantsInput.removeAttribute('disabled');
        accountNumberInput.removeAttribute('disabled');
        employmentContractInput.removeAttribute('disabled');
        statusRadios.forEach(item => {
            item.removeAttribute('disabled');
        });
        saveButton.removeAttribute('disabled');
        closeButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.nik) {
            nikInput.classList.add('is-invalid');
            nikInput.nextElementSibling.textContent = errors.nik[0];
        }
        if (errors.name) {
            nameInput.classList.add('is-invalid');
            nameInput.nextElementSibling.textContent = errors.name[0];
        }
        if (errors.username) {
            usernameInput.classList.add('is-invalid');
            usernameInput.nextElementSibling.textContent = errors.username[0];
        }
        if (errors.email) {
            emailInput.classList.add('is-invalid');
            emailInput.nextElementSibling.textContent = errors.email[0];
        }
        if (errors.password) {
            passwordInput.classList.add('is-invalid');
            passwordInput.nextElementSibling.textContent = errors.password[0];
        }
        if (errors.birth_place) {
            birthPlaceInput.classList.add('is-invalid');
            birthPlaceInput.nextElementSibling.textContent = errors.birth_place[0];
        }
        if (errors.birth_date) {
            birthDateInput.classList.add('is-invalid');
            birthDateInput.nextElementSibling.nextElementSibling.textContent = errors.birth_date[0];
        }
        if (errors.position_id) {
            positionInput.classList.add('is-invalid');
            positionInput.nextElementSibling.textContent = errors.position_id[0];
        }
        if (errors.marital_status) {
            maritalStatusInput.classList.add('is-invalid');
            maritalStatusInput.nextElementSibling.textContent = errors.marital_status[0];
        }
        if (errors.npwp) {
            npwpInput.classList.add('is-invalid');
            npwpInput.nextElementSibling.textContent = errors.npwp[0];
        }
        if (errors.phone_number) {
            phoneNumberInput.classList.add('is-invalid');
            phoneNumberInput.nextElementSibling.textContent = errors.phone_number[0];
        }
        if (errors.health_insurance_number) {
            healthInsuranceNumber.classList.add('is-invalid');
            healthInsuranceNumber.nextElementSibling.textContent = errors.health_insurance_number[0];
        }
        if (errors.health_insurance_id) {
            healthInsuranceInput.classList.add('is-invalid');
            healthInsuranceInput.nextElementSibling.textContent = errors.health_insurance_id[0];
        }
        if (errors.number_of_dependants) {
            numberOfDependantsInput.classList.add('is-invalid');
            numberOfDependantsInput.nextElementSibling.textContent = errors.number_of_dependants[0];
        }
        if (errors.account_number) {
            accountNumberInput.classList.add('is-invalid');
            accountNumberInput.nextElementSibling.textContent = errors.account_number[0];
        }
        if (errors.employment_contract) {
            employmentContractInput.classList.add('is-invalid');
            employmentContractInput.nextElementSibling.textContent = errors.employment_contract[0];
        }
        if (errors.is_active) {
            statusRadios[0].parentElement.parentElement.parentElement.nextElementSibling.textContent = errors.is_active[0];
        }
    };

    const clearErrors = () => {
        nikInput.classList.remove('is-invalid');
        nikInput.nextElementSibling.textContent = '';
        nameInput.classList.remove('is-invalid');
        nameInput.nextElementSibling.textContent = '';
        usernameInput.classList.remove('is-invalid');
        usernameInput.nextElementSibling.textContent = '';
        emailInput.classList.remove('is-invalid');
        emailInput.nextElementSibling.textContent = '';
        passwordInput.classList.remove('is-invalid');
        passwordInput.nextElementSibling.textContent = '';
        birthPlaceInput.classList.remove('is-invalid');
        birthPlaceInput.nextElementSibling.textContent = '';
        birthDateInput.classList.remove('is-invalid');
        birthDateInput.nextElementSibling.nextElementSibling.textContent = '';
        positionInput.classList.remove('is-invalid');
        positionInput.nextElementSibling.textContent = '';
        maritalStatusInput.classList.remove('is-invalid');
        maritalStatusInput.nextElementSibling.textContent = '';
        npwpInput.classList.remove('is-invalid');
        npwpInput.nextElementSibling.textContent = '';
        phoneNumberInput.classList.remove('is-invalid');
        phoneNumberInput.nextElementSibling.textContent = '';
        healthInsuranceNumber.classList.remove('is-invalid');
        healthInsuranceNumber.nextElementSibling.textContent = '';
        healthInsuranceInput.classList.remove('is-invalid');
        healthInsuranceInput.nextElementSibling.textContent = '';
        numberOfDependantsInput.classList.remove('is-invalid');
        numberOfDependantsInput.nextElementSibling.textContent = '';
        accountNumberInput.classList.remove('is-invalid');
        accountNumberInput.nextElementSibling.textContent = '';
        employmentContractInput.classList.remove('is-invalid');
        employmentContractInput.nextElementSibling.textContent = '';
        statusRadios[0].parentElement.parentElement.parentElement.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const body = {
            nik: nikInput.value,
            name: nameInput.value,
            username: usernameInput.value,
            email: emailInput.value,
            password: passwordInput.value,
            birth_place: birthPlaceInput.value,
            birth_date: birthDateInput.value,
            position_id: positionInput.value,
            marital_status: maritalStatusInput.value,
            npwp: npwpInput.value,
            phone_number: phoneNumberInput.value,
            health_insurance_number: healthInsuranceNumber.value,
            health_insurance_id: healthInsuranceInput.value,
            number_of_dependants: numberOfDependantsInput.value,
            account_number: accountNumberInput.value,
            employment_contract: employmentContractInput.value,
            is_active: getSelectedValueRadio(statusRadios),
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

        const response = await fetch(`${window.location.origin}/panel/pegawai`, options);
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
