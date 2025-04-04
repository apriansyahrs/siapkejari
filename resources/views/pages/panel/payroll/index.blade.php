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
                        <h2 class="page-title">Payroll</h2>
                    </div>
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <div class="dropstart">
                                <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 5l0 14" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                    Tambah
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#modal-report">Single</a></li>
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#generate-report">Generate</a></li>
                                </ul>
                            </div>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                                data-bs-target="#modal-report" aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
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
                                <form action="{{ route('panel.payroll') }}" method="get">
                                    <div class="row align-items-end">
                                        <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                            <label for="" class="col-form-label">Periode</label>
                                            <input type="text" class="form-control" name="period_filter"
                                                value="{{ \Carbon\Carbon::parse($period)->format('m-Y') }}"
                                                autocomplete="off" readonly>
                                        </div>
                                        <div class="col-12 col-lg-1">
                                            <div class="d-grid">
                                                <button class="btn btn-primary" type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" />
                                                    </svg>
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
                                            <th>Periode</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($payrolls->count() > 0)
                                            @foreach ($payrolls as $index => $item)
                                                <tr>
                                                    <td>{{ ($payrolls->currentpage() - 1) * $payrolls->perpage() + $index + 1 }}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('panel.payroll.show', $item->id) }}">
                                                            {{ $item->employee->name }}
                                                        </a>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($item->period)->format('F Y') }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3">Tidak ada data</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('partials.panel._copyright')
    </div>
    <div class="modal modal-blur modal-lg fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payroll <small>(Single)</small></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Periode</label>
                            <input type="text" class="form-control" name="period" maxlength="7"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Nama Pegawai</label>
                            <select name="employee" id="" class="form-select" disabled>
                                <option value="">Pilih</option>
                                @foreach ($employees as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">No. Kontrak Kerja</label>
                            <input type="text" class="form-control" name="employment-contract" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Gaji Pokok</label>
                            <input type="text" class="form-control" name="salary" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Tunjangan Pph 21</label>
                            <input type="text" class="form-control" name="pph-21-allowance" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Potongan Pph 21</label>
                            <input type="text" class="form-control" name="pph-21-deduction" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Potongan Absensi</label>
                            <input type="text" class="form-control" name="attendance-deduction" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Iuran Jamkes</label>
                            <input type="text" class="form-control" name="health-insurance-contribution" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Iuran Jamkes Kel. Lainnya</label>
                            <input type="text" class="form-control" name="other-family-health-insurance-contribution"
                                disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Total Potongan</label>
                            <input type="text" class="form-control" name="total-deduction" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Jumlah Gaji Bersih</label>
                            <input type="text" class="form-control" name="net-salary" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-6">
                            <label class="form-label">No. Rekening</label>
                            <input type="text" class="form-control" name="account-number" disabled>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label">Tgl. Dibayarkan</label>
                            <input type="text" class="form-control" name="payment-date" maxlength="10"
                                autocomplete="off">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save" type="button" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="generate-report" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payroll <small>(Generate)</small></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Periode</label>
                        <input type="text" class="form-control" name="period-generate" maxlength="7"
                            autocomplete="off">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tgl. Dibayarkan</label>
                        <input type="text" class="form-control" name="payment-date-generate" maxlength="10"
                            autocomplete="off">
                        <div class="invalid-feedback"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="save-generate" type="button" class="btn btn-primary ms-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const periodFilterInput = document.querySelector('input[name="period_filter"]');
        const employeeInput = document.querySelector('select[name="employee"]');
        const employmentContractInput = document.querySelector('input[name="employment-contract"]');
        const salaryInput = document.querySelector('input[name="salary"]');
        const pph21AllowanceInput = document.querySelector('input[name="pph-21-allowance"]');
        const pph21DeductionInput = document.querySelector('input[name="pph-21-deduction"]');
        const attendanceDeductionInput = document.querySelector('input[name="attendance-deduction"]');
        const healthInsuranceContributionInput = document.querySelector('input[name="health-insurance-contribution"]');
        const otherFamilyHealthInsuranceContributionInput = document.querySelector(
            'input[name="other-family-health-insurance-contribution"]');
        const totalDeductionInput = document.querySelector('input[name="total-deduction"]');
        const netSalaryInput = document.querySelector('input[name="net-salary"]');
        const periodInput = document.querySelector('input[name="period"]');
        const accountNumberInput = document.querySelector('input[name="account-number"]');
        const paymentDateInput = document.querySelector('input[name="payment-date"]');
        const saveButton = document.getElementById('save');
        const closeButton = document.querySelector('button.btn-close');
        const periodGenerateInput = document.querySelector('input[name="period-generate"]');
        const paymentDateGenerateInput = document.querySelector('input[name="payment-date-generate"]');
        const saveGenerateButton = document.getElementById('save-generate');
        const plusIcon =
            '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
        const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
        const csrfToken = '{{ csrf_token() }}';

        // Set up the datepickers
        const datepickerPeriod = new Datepicker(periodInput, {
            autohide: true,
            format: 'mm-yyyy',
            maxView: 1,
            pickLevel: 1,
            maxDate: new Date(),
        });

        // Add event listener for period input changes
        periodInput.addEventListener('changeDate', function() {
            if (periodInput.value) {
                // Enable employee select when period is selected
                employeeInput.removeAttribute('disabled');

                // If employee is already selected, update the data
                if (employeeInput.value) {
                    getEmployee(employeeInput.value).then(response => {
                        if (response.data) {
                            updateEmployeeData(response.data);
                        }
                    });
                }
            } else {
                // Disable employee select if period is cleared
                employeeInput.setAttribute('disabled', '');
                employeeInput.value = '';
                clearEmployeeData();
            }
        });

        // Also listen for manual changes to period input
        periodInput.addEventListener('change', function() {
            if (periodInput.value) {
                employeeInput.removeAttribute('disabled');

                // If employee is already selected, update the data
                if (employeeInput.value) {
                    getEmployee(employeeInput.value).then(response => {
                        if (response.data) {
                            updateEmployeeData(response.data);
                        }
                    });
                }
            } else {
                employeeInput.setAttribute('disabled', '');
                employeeInput.value = '';
                clearEmployeeData();
            }
        });

        // Function to clear all employee data fields
        const clearEmployeeData = () => {
            employmentContractInput.value = '';
            salaryInput.value = '';
            pph21AllowanceInput.value = '';
            pph21DeductionInput.value = '';
            attendanceDeductionInput.value = '';
            healthInsuranceContributionInput.value = '';
            otherFamilyHealthInsuranceContributionInput.value = '';
            totalDeductionInput.value = '';
            netSalaryInput.value = '';
            accountNumberInput.value = '';
        };

        // Function to update employee data fields
        const updateEmployeeData = (data) => {
            employmentContractInput.value = data.employment_contract;
            salaryInput.value = data.salary;
            pph21AllowanceInput.value = data.allowance_pph_21;
            pph21DeductionInput.value = data.deduction_pph_21;
            attendanceDeductionInput.value = data.attendance_deduction;
            healthInsuranceContributionInput.value = data.health_insurance_contribution;
            otherFamilyHealthInsuranceContributionInput.value = data.other_family_health_insurance_contribution;
            totalDeductionInput.value = data.total_deduction;
            netSalaryInput.value = data.net_salary;
            accountNumberInput.value = data.account_number;
        };

        new Datepicker(paymentDateInput, {
            autohide: true,
            format: 'dd-mm-yyyy',
            maxView: 1,
            maxDate: new Date(),
        });

        new Datepicker(periodGenerateInput, {
            autohide: true,
            format: 'mm-yyyy',
            maxView: 1,
            pickLevel: 1,
            maxDate: new Date(),
        });

        new Datepicker(paymentDateGenerateInput, {
            autohide: true,
            format: 'dd-mm-yyyy',
            maxView: 1,
            maxDate: new Date(),
        });

        new Datepicker(periodFilterInput, {
            autohide: true,
            format: 'mm-yyyy',
            maxView: 1,
            pickLevel: 1,
            maxDate: new Date(),
        });

        employeeInput.addEventListener('change', async (e) => {
            if (e.target.value) {
                const response = await getEmployee(e.target.value);

                if (response.data) {
                    updateEmployeeData(response.data);
                }
            } else {
                clearEmployeeData();
            }
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
            periodInput.setAttribute('disabled', '');
            paymentDateInput.setAttribute('disabled', '');
            saveButton.setAttribute('disabled', '');
            closeButton.setAttribute('disabled', '');
            saveButton.innerHTML = `${spinnerIcon} Loading`;
        };

        const enabledElement = () => {
            employeeInput.removeAttribute('disabled');
            periodInput.removeAttribute('disabled', '');
            paymentDateInput.removeAttribute('disabled');
            saveButton.removeAttribute('disabled');
            closeButton.removeAttribute('disabled');
            saveButton.innerHTML = `${plusIcon} Simpan`;
        };

        const showErrors = (errors) => {
            if (errors.employee_id) {
                employeeInput.classList.add('is-invalid');
                employeeInput.nextElementSibling.textContent = errors.employee_id[0];
            }
            if (errors.employment_contract) {
                employmentContractInput.classList.add('is-invalid');
                employmentContractInput.nextElementSibling.textContent = errors.employment_contract[0];
            }
            if (errors.salary) {
                salaryInput.classList.add('is-invalid');
                salaryInput.nextElementSibling.textContent = errors.salary[0];
            }
            if (errors.pph_21_allowance) {
                pph21AllowanceInput.classList.add('is-invalid');
                pph21AllowanceInput.nextElementSibling.textContent = errors.pph_21_allowance[0];
            }
            if (errors.pph_21_deduction) {
                pph21DeductionInput.classList.add('is-invalid');
                pph21DeductionInput.nextElementSibling.textContent = errors.pph_21_deduction[0];
            }
            if (errors.attendance_deduction) {
                attendanceDeductionInput.classList.add('is-invalid');
                attendanceDeductionInput.nextElementSibling.textContent = errors.attendance_deduction[0];
            }
            if (errors.health_insurance_contribution) {
                healthInsuranceContributionInput.classList.add('is-invalid');
                healthInsuranceContributionInput.nextElementSibling.textContent = errors.health_insurance_contribution[
                    0];
            }
            if (errors.other_family_health_insurance_contribution) {
                otherFamilyHealthInsuranceContributionInput.classList.add('is-invalid');
                otherFamilyHealthInsuranceContributionInput.nextElementSibling.textContent = errors
                    .other_family_health_insurance_contribution[0];
            }
            if (errors.total_deduction) {
                totalDeductionInput.classList.add('is-invalid');
                totalDeductionInput.nextElementSibling.textContent = errors.total_deduction[0];
            }
            if (errors.net_salary) {
                netSalaryInput.classList.add('is-invalid');
                netSalaryInput.nextElementSibling.textContent = errors.net_salary[0];
            }
            if (errors.period) {
                periodInput.classList.add('is-invalid');
                periodInput.nextElementSibling.nextElementSibling.textContent = errors.period[0];
            }
            if (errors.account_number) {
                accountNumberInput.classList.add('is-invalid');
                accountNumberInput.nextElementSibling.textContent = errors.account_number[0];
            }
            if (errors.payment_date) {
                paymentDateInput.classList.add('is-invalid');
                paymentDateInput.nextElementSibling.nextElementSibling.textContent = errors.payment_date[0];
            }
        };

        const clearErrors = () => {
            employeeInput.classList.remove('is-invalid');
            employeeInput.nextElementSibling.textContent = '';
            employmentContractInput.classList.remove('is-invalid');
            employmentContractInput.nextElementSibling.textContent = '';
            salaryInput.classList.remove('is-invalid');
            salaryInput.nextElementSibling.textContent = '';
            pph21AllowanceInput.classList.remove('is-invalid');
            pph21AllowanceInput.nextElementSibling.textContent = '';
            pph21DeductionInput.classList.remove('is-invalid');
            pph21DeductionInput.nextElementSibling.textContent = '';
            attendanceDeductionInput.classList.remove('is-invalid');
            attendanceDeductionInput.nextElementSibling.textContent = '';
            healthInsuranceContributionInput.classList.remove('is-invalid');
            healthInsuranceContributionInput.nextElementSibling.textContent = '';
            otherFamilyHealthInsuranceContributionInput.classList.remove('is-invalid');
            otherFamilyHealthInsuranceContributionInput.nextElementSibling.textContent = '';
            totalDeductionInput.classList.remove('is-invalid');
            totalDeductionInput.nextElementSibling.textContent = '';
            netSalaryInput.classList.remove('is-invalid');
            netSalaryInput.nextElementSibling.textContent = '';
            periodInput.classList.remove('is-invalid');
            periodInput.nextElementSibling.nextElementSibling.textContent = '';
            accountNumberInput.classList.remove('is-invalid');
            accountNumberInput.nextElementSibling.textContent = '';
            paymentDateInput.classList.remove('is-invalid');
            paymentDateInput.nextElementSibling.nextElementSibling.textContent = '';
        };

        const save = async () => {
            const body = {
                employee_id: employeeInput.value,
                employment_contract: employmentContractInput.value,
                salary: salaryInput.value,
                pph_21_allowance: pph21AllowanceInput.value,
                pph_21_deduction: pph21DeductionInput.value,
                attendance_deduction: attendanceDeductionInput.value,
                health_insurance_contribution: healthInsuranceContributionInput.value,
                other_family_health_insurance_contribution: otherFamilyHealthInsuranceContributionInput.value,
                total_deduction: totalDeductionInput.value,
                net_salary: netSalaryInput.value,
                period: periodInput.value,
                account_number: accountNumberInput.value,
                payment_date: paymentDateInput.value,
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

            const response = await fetch(`${window.location.origin}/panel/payroll`, options);
            const result = await response.json();
            return result;
        };

        const getEmployee = async (username) => {
            if (!periodInput.value) {
                return {
                    data: null
                };
            }

            const period = periodInput.value;
            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    period
                })
            };
            const response = await fetch(`${window.location.origin}/panel/payroll/hitung/${username}`, options);
            const result = await response.json();
            return result;
        }

        saveGenerateButton.addEventListener('click', async () => {
            disabledGenerateElement();

            const response = await saveGenerate();

            if (response.status === 'success') {
                return window.location.href = `${window.location.origin}/panel/payroll`;
            }

            if (response.errors) {
                showGenerateErrors(response.errors)
            }

            enabledGenerateElement();
        });

        const disabledGenerateElement = () => {
            periodGenerateInput.setAttribute('disabled', '');
            paymentDateGenerateInput.setAttribute('disabled', '');
            saveGenerateButton.setAttribute('disabled', '');
            saveGenerateButton.innerHTML = `${spinnerIcon} Loading`;
        }

        const enabledGenerateElement = () => {
            periodGenerateInput.removeAttribute('disabled');
            paymentDateGenerateInput.removeAttribute('disabled');
            saveGenerateButton.removeAttribute('disabled');
            saveGenerateButton.innerHTML = `${plusIcon} Simpan`;
        }

        const clearGenerateErrors = () => {
            periodGenerateInput.classList.remove('is-invalid');
            periodGenerateInput.nextElementSibling.nextElementSibling.textContent = '';
            paymentDateGenerateInput.classList.remove('is-invalid');
            paymentDateGenerateInput.nextElementSibling.nextElementSibling.textContent = '';
        }

        const showGenerateErrors = (errors) => {
            if (errors.period) {
                periodGenerateInput.classList.add('is-invalid');
                periodGenerateInput.nextElementSibling.nextElementSibling.textContent = errors.period[0];
            }
            if (errors.payment_date) {
                paymentDateGenerateInput.classList.add('is-invalid');
                paymentDateGenerateInput.nextElementSibling.nextElementSibling.textContent = errors.payment_date[0];
            }
        }

        const saveGenerate = async () => {
            const body = {
                period: periodGenerateInput.value,
                payment_date: paymentDateGenerateInput.value,
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

            const response = await fetch(`${window.location.origin}/panel/payroll/generate`, options);
            const result = await response.json();
            return result;
        }
    </script>
@endpush
