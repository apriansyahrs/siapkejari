@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-4 col-lg-4">
                            <h2 class="page-title">Pegawai</h2>
                        </div>
                        <div class="col-8 col-lg-8 text-end">
                            @if ($employee->is_active)
                                @if ($employee->is_free_radius)
                                <form action="{{ route('panel.employee.deactivate-free-radius', $employee->username) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button
                                        type="submit"
                                        class="btn text-danger"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Nonaktifkan Radius Bebas"
                                        onclick="return confirm('Yakin ingin menonaktifkan radius bebas?')"
                                    >
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin-x m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M13.024 21.204a2 2 0 0 1 -2.437 -.304l-4.244 -4.243a8 8 0 1 1 13.119 -2.766" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('panel.employee.activate-free-radius', $employee->username) }}" method="post" class="d-inline-block">
                                    @csrf
                                    @method('PUT')
                                    <button
                                        type="submit"
                                        class="btn text-success"
                                        data-bs-toggle="tooltip"
                                        data-bs-placement="top"
                                        data-bs-title="Aktifkan Radius Bebas"
                                        onclick="return confirm('Yakin ingin mengaktifkan radius bebas?')"
                                    >
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-pin-check m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /><path d="M11.87 21.48a1.992 1.992 0 0 1 -1.283 -.58l-4.244 -4.243a8 8 0 1 1 13.355 -3.474" /><path d="M15 19l2 2l4 -4" /></svg>
                                    </button>
                                </form>
                                @endif
                            <form action="{{ route('panel.employee.reset-password', $employee->username) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('PUT')
                                <button
                                    type="submit"
                                    class="btn text-primary"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="Reset Password"
                                    onclick="return confirm('Yakin ingin me-reset password pegawai?')"
                                >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-key m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" /><path d="M15 9h.01" /></svg>
                                </button>
                            </form>
                            <form action="{{ route('panel.employee.deactivate', $employee->username) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('PUT')
                                <button
                                    type="submit"
                                    class="btn text-danger"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="Nonaktifkan"
                                    onclick="return confirm('Yakin ingin menonaktifkan pegawai?')"
                                >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-power m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6a7.75 7.75 0 1 0 10 0" /><path d="M12 4l0 8" /></svg>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('panel.employee.activate', $employee->username) }}" method="post" class="d-inline-block">
                                @method('PUT')
                                @csrf
                                <button
                                    type="submit"
                                    class="btn text-success"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="Aktifkan"
                                    onclick="return confirm('Yakin ingin mengaktifkan pegawai?')"
                                >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-power m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 6a7.75 7.75 0 1 0 10 0" /><path d="M12 4l0 8" /></svg>
                                </button>
                            </form>
                            <form action="{{ route('panel.employee.destroy', $employee->username) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus pegawai?')"
                                >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards justify-content-center">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <label class="form-label">NIK</label>
                                    <p class="mb-0">{{ $employee->nik }}</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Username</label>
                                    <p class="mb-0">{{ $employee->username }}</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Email</label>
                                    <p class="mb-0">{{ $employee->email }}</p>
                                </div>
                                <div class="col-6 mb-2">
                                    <label class="form-label">Status</label>
                                    @if ($employee->is_active)
                                    <span class="badge bg-success-lt">Aktif</span>
                                    @else
                                    <span class="badge bg-secondary-lt">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="my-3">
                                    <label class="form-label">Nama</label>
                                    <input type="text" class="form-control" name="name" value="{{ $employee->name }}">
                                    <div class="invalid-feedback"></div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" name="birth-place" value="{{ $employee->birth_place }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Tgl. Lahir</label>
                                    <input type="text" class="form-control" name="birth-date" value="{{ \Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y') }}" maxlength="10" autocomplete="off">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">Jabatan</label>
                                    <select name="position" id="" class="form-select">
                                        <option value="">Pilih</option>
                                        @foreach ($positions as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $employee->position_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Status Perkawinan</label>
                                    <select name="marital-status" id="" class="form-select">
                                        <option value="">Pilih</option>
                                        <option value="Belum Kawin" {{ $employee->marital_status === 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                        <option value="Kawin" {{ $employee->marital_status === 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                        <option value="Cerai Hidup" {{ $employee->marital_status === 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                        <option value="Cerai Mati" {{ $employee->marital_status === 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">NPWP</label>
                                    <input type="text" class="form-control" name="npwp" value="{{ $employee->npwp }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">No. HP</label>
                                    <input type="text" class="form-control" name="phone-number" value="{{ $employee->phone_number }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label class="form-label">No. BPJS</label>
                                    <input type="text" class="form-control" name="health-insurance-number" value="{{ $employee->health_insurance_number }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Kelas BPJS</label>
                                    <select name="bpjs-class" id="" class="form-select">
                                        <option value="">Pilih</option>
                                        @foreach ($healthInsurances as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $employee->health_insurance_id ? 'selected' : '' }}>{{ $item->class }} &mdash; Rp{{ number_format($item->contribution, 0, '', ',') }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label">Jml. Tanggungan</label>
                                    <input type="text" class="form-control" name="number-of-dependants" value="{{ $employee->number_of_dependants }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <label class="form-label">No. Rekening <small>(opsional)</small></label>
                                    <input type="text" class="form-control" name="account-number" value="{{ $employee->account_number }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">No. Kontrak Kerja</label>
                                    <input type="text" class="form-control" name="employment-contract" value="{{ $employee->employment_contract }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="save" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
@endsection

@push('scripts')
<script>
    const username = '{{ $employee->username }}';
    const nameInput = document.querySelector('input[name="name"]');
    const birthPlaceInput = document.querySelector('input[name="birth-place"]');
    const birthDateInput = document.querySelector('input[name="birth-date"]');
    const positionInput = document.querySelector('select[name="position"]');
    const maritalStatusInput = document.querySelector('select[name="marital-status"]');
    const npwpInput = document.querySelector('input[name="npwp"]');
    const phoneNumberInput = document.querySelector('input[name="phone-number"]');
    const healthInsuranceNumberInput = document.querySelector('input[name="health-insurance-number"]');
    const healthInsuranceInput = document.querySelector('select[name="health-insurance"]');
    const numberOfDependantsInputInput = document.querySelector('input[name="number-of-dependants"]');
    const accountNumberInput = document.querySelector('input[name="account-number"]');
    const employmentContractInput = document.querySelector('input[name="employment-contract"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
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
            return window.location.href = `${window.location.origin}/panel/pegawai`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        nameInput.setAttribute('disabled', '');
        birthPlaceInput.setAttribute('disabled', '');
        birthDateInput.setAttribute('disabled', '');
        positionInput.setAttribute('disabled', '');
        maritalStatusInput.setAttribute('disabled', '');
        npwpInput.setAttribute('disabled', '');
        phoneNumberInput.setAttribute('disabled', '');
        healthInsuranceNumberInput.setAttribute('disabled', '');
        healthInsuranceInput.setAttribute('disabled', '');
        numberOfDependantsInputInput.setAttribute('disabled', '');
        accountNumberInput.setAttribute('disabled', '');
        employmentContractInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        nameInput.removeAttribute('disabled');
        birthPlaceInput.removeAttribute('disabled');
        birthDateInput.removeAttribute('disabled');
        positionInput.removeAttribute('disabled');
        maritalStatusInput.removeAttribute('disabled');
        npwpInput.removeAttribute('disabled');
        phoneNumberInput.removeAttribute('disabled');
        healthInsuranceNumberInput.removeAttribute('disabled');
        healthInsuranceInput.removeAttribute('disabled');
        numberOfDependantsInputInput.removeAttribute('disabled');
        accountNumberInput.removeAttribute('disabled');
        employmentContractInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.name) {
            nameInput.classList.add('is-invalid');
            nameInput.nextElementSibling.textContent = errors.name[0];
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
            healthInsuranceNumberInput.classList.add('is-invalid');
            healthInsuranceNumberInput.nextElementSibling.textContent = errors.health_insurance_number[0];
        }
        if (errors.health_insurance_id) {
            healthInsuranceInput.classList.add('is-invalid');
            healthInsuranceInput.nextElementSibling.textContent = errors.health_insurance_id[0];
        }
        if (errors.number_of_dependants) {
            numberOfDependantsInputInput.classList.add('is-invalid');
            numberOfDependantsInputInput.nextElementSibling.textContent = errors.number_of_dependants[0];
        }
        if (errors.account_number) {
            accountNumberInput.classList.add('is-invalid');
            accountNumberInput.nextElementSibling.textContent = errors.account_number[0];
        }
        if (errors.employment_contract) {
            employmentContractInput.classList.add('is-invalid');
            employmentContractInput.nextElementSibling.textContent = errors.employment_contract[0];
        }
    };

    const clearErrors = () => {
        nameInput.classList.remove('is-invalid');
        nameInput.nextElementSibling.textContent = '';
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
        healthInsuranceNumberInput.classList.remove('is-invalid');
        healthInsuranceNumberInput.nextElementSibling.textContent = '';
        healthInsuranceInput.classList.remove('is-invalid');
        healthInsuranceInput.nextElementSibling.textContent = '';
        numberOfDependantsInputInput.classList.remove('is-invalid');
        numberOfDependantsInputInput.nextElementSibling.textContent = '';
        accountNumberInput.classList.remove('is-invalid');
        accountNumberInput.nextElementSibling.textContent = '';
        employmentContractInput.classList.remove('is-invalid');
        employmentContractInput.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            name: nameInput.value,
            birth_place: birthPlaceInput.value,
            birth_date: birthDateInput.value,
            position_id: positionInput.value,
            marital_status: maritalStatusInput.value,
            npwp: npwpInput.value,
            phone_number: phoneNumberInput.value,
            health_insurance_number: healthInsuranceNumberInput.value,
            health_insurance_id: healthInsuranceInput.value,
            number_of_dependants: numberOfDependantsInputInput.value,
            account_number: accountNumberInput.value,
            employment_contract: employmentContractInput.value,
        };
        const encodedBody = new URLSearchParams(body);

        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: encodedBody,
        };

        const response = await fetch(`${window.location.origin}/panel/pegawai/@${username}`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
