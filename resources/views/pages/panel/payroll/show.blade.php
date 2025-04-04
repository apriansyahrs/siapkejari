@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-6">
                            <h2 class="page-title">Payroll</h2>
                        </div>
                        <div class="col-6 text-end">
                            <form action="{{ route('panel.payroll.download', $payroll->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary" id="download">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                    Unduh
                                </button>
                            </form>
                            {{-- <a href="{{ route('panel.payroll.download', $payroll->id) }}" class="btn btn-primary" id="download">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
                                Unduh
                            </a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Pegawai</label>
                                    <p class="mb-0">{{ $payroll->employee->name }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Periode</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($payroll->period)->translatedFormat('F Y') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Gaji Pokok</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->salary, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Tunjangan Pph 21</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->pph_21_allowance, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Potongan Pph 21</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->pph_21_deduction, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Iuran Jaminan Kesehatan</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->health_insurance_contribution, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Iuran Jaminan Kesehatan Kel. Lainnya</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->other_family_health_insurance_contribution, 0, '', ',') }} ({{ $payroll->marital_status === 'Kawin' ? $payroll->other_family_health_insurance + 1 : $payroll->other_family_health_insurance }} orang)</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Potongan Absensi</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->attendance_deduction, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Total Potongan</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->total_deduction, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Gaji Bersih</label>
                                    <p class="mb-0">Rp. {{ number_format($payroll->net_salary, 0, '', ',') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">Tgl. Pembayaran</label>
                                    <p class="mb-0">{{ \Carbon\Carbon::parse($payroll->payment_date)->translatedFormat('d F Y') }}</p>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label mb-0">No. Rekening</label>
                                    <p class="mb-0">{{ $payroll->account_number }}</p>
                                </div>
                            </div>
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
    const id = '{{ $payroll->id }}';
    const nameInput = document.querySelector('input[name="name"]');
    const salaryInput = document.querySelector('input[name="salary"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/panel/jabatan`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        nameInput.setAttribute('disabled', '');
        salaryInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        nameInput.removeAttribute('disabled');
        salaryInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
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
    };

    const clearErrors = () => {
        nameInput.classList.remove('is-invalid');
        nameInput.nextElementSibling.textContent = '';
        salaryInput.classList.remove('is-invalid');
        salaryInput.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            name: nameInput.value,
            salary: salaryInput.value,
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

        const response = await fetch(`${window.location.origin}/panel/jabatan/${id}`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
