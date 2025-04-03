<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneratePayrollRequest;
use App\Http\Requests\StorePayrollRequest;
use App\Repositories\EmployeeRepository;
use App\Repositories\PayrollRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PayrollController extends Controller
{
    protected $payrollRepository;
    protected $employeeRepository;

    public function __construct(PayrollRepository $payrollRepository, EmployeeRepository $employeeRepository)
    {
        $this->payrollRepository = $payrollRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $period = request()->period_filter ? Carbon::parse('01-'.request()->period_filter)->format('Y-m-d') : date('Y-m-01');
        $title = 'Payroll';
        $employees = $this->employeeRepository->getActive();
        $payrolls = $this->payrollRepository->getByPeriodWithPagination($period, 10);
        return view('pages.panel.payroll.index', compact('title', 'employees', 'payrolls', 'period'));
    }

    public function show($id)
    {
        $payroll = $this->payrollRepository->getById($id);

        if (!$payroll) {
            abort(404);
        }

        $title = 'Payroll';
        return view('pages.panel.payroll.show', compact('title', 'payroll'));
    }

    public function store(StorePayrollRequest $request)
    {
        $payload = $request->only([
            'employee_id',
            'employment_contract',
            'salary',
            'pph_21_allowance',
            'pph_21_deduction',
            'health_insurance_contribution',
            'other_family_health_insurance_contribution',
            'total_deduction',
            'net_salary',
            'period',
            'account_number',
            'payment_date',
        ]);

        $payroll = $this->payrollRepository->getByEmployeeIdAndPeriod($payload['employee_id'], Carbon::parse('01-'.$payload['period'])->format('Y-m-d'));

        if ($payroll) {
            return response()->json([
                'status' => 'failed',
                'errors' => [
                    'period' => ['payroll sudah dibuat']
                ]
            ]);
        }

        $employee = $this->employeeRepository->getById($payload['employee_id']);
        $numberOfDependants = $employee->number_of_dependants;

        if ($employee->marital_status === 'Kawin') {
            $numberOfDependants += 1;
        }

        $payload['other_family_health_insurance'] = $numberOfDependants;
        $this->payrollRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Payroll berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function generate(GeneratePayrollRequest $request)
    {
        $paymentDate = Carbon::parse($request->payment_date)->format('Y-m-d');
        $period = Carbon::parse('01-'.$request->period)->format('Y-m-d');
        $employees = $this->employeeRepository->getActive()->load(['position', 'healthInsurance']);
        $existingPayrolls = $this->payrollRepository->getByPeriod($period);
        $existingEmployeeIds = $existingPayrolls->pluck('employee_id')->toArray();
        $payload = [];

        foreach ($employees as $employee) {
            if (!in_array($employee->id, $existingEmployeeIds)) {
                $calculatePayroll = $this->calculate($employee->id);
                $payroll = [
                    'employee_id' => $employee->id,
                    'employment_contract' => $employee->employment_contract,
                    'salary' => $employee->position->salary,
                    'pph_21_allowance' => $calculatePayroll['allowance_pph_21'],
                    'pph_21_deduction' => $calculatePayroll['deduction_pph_21'],
                    'health_insurance_contribution' => $employee->healthInsurance->contribution,
                    'other_family_health_insurance_contribution' => $calculatePayroll['other_family_health_insurance_contribution'],
                    'other_family_health_insurance' => $calculatePayroll['other_family_health_insurance'],
                    'total_deduction' => $calculatePayroll['total_deduction'],
                    'net_salary' => $calculatePayroll['net_salary'],
                    'account_number' => $employee->account_number,
                    'payment_date' => $paymentDate,
                    'period' => $period
                ];
                array_push($payload, $payroll);
            }
        }

        if (count($payload) < 1) {
            return response()->json([
                'status' => 'failed',
                'errors' => [
                    'period' => ['payroll sudah dibuat']
                ]
            ]);
        }

        $this->payrollRepository->bulkInsert($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Payroll berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function download($id)
    {
        $payroll = $this->payrollRepository->getById($id);
        $filename = 'Slip Gaji Pegawai - '.$payroll->employee->name.'_'.Carbon::parse($payroll->period)->translatedFormat('F Y').'.pdf';
        $pdf = Pdf::loadView('printed.payroll.single', ['payroll' => $payroll]);
        return $pdf->download($filename);
    }

    private function calculatePph21($employee)
    {
        $initialPtkp = 54000000;

        if ($employee->marital_status === 'Kawin') {
            $initialPtkp = 58500000;
        }

        $additionalPtkp = 4500000 * $employee->number_of_dependants;
        $totalPtkp = $initialPtkp + $additionalPtkp;

        $netSalaryPerMonth = $employee->position->salary;
        $healthInsuranceContribution = 0;
        $otherFamilyHealthInsurance = $employee->number_of_dependants;

        if ($employee->healthInsurance) {
            $healthInsuranceContribution = $employee->healthInsurance->contribution;
        }

        if ($employee->marital_status === 'Kawin') {
            $otherFamilyHealthInsurance += 1;
        }

        $otherFamilyHealthInsuranceContribution = $healthInsuranceContribution * $otherFamilyHealthInsurance;
        $totalHealthInsuranceContribution = $healthInsuranceContribution + $otherFamilyHealthInsuranceContribution;
        $netSalaryPerMonth -= $totalHealthInsuranceContribution;
        $netSalaryPerYear = $netSalaryPerMonth * 12;
        $pkp = $netSalaryPerYear - $totalPtkp;

        if ($pkp <= 0) {
            $percentageTax = 0;
        } elseif ($pkp <= 60000000) {
            $percentageTax = (5 * 100);
        } elseif ($pkp <= 250000000) {
            $percentageTax = (15 * 100);
        } elseif ($pkp <= 500000000) {
            $percentageTax = (25 * 100);
        } elseif ($pkp <= 5000000000) {
            $percentageTax = (30 * 100);
        } else {
            $percentageTax = (35 * 100);
        }

        return $percentageTax * $pkp;
    }

    public function calculate($employeeId)
    {
        $employee = $this->employeeRepository->getById($employeeId);
        $pph21Deduction = $this->calculatePph21($employee);
        $healthInsuranceContribution = $employee->healthInsurance->contribution;
        $otherFamilyHealthInsurance = $employee->number_of_dependants;

        if ($employee->marital_status === 'Kawin') {
            $otherFamilyHealthInsurance += 1;
        }

        $otherFamilyHealthInsuranceContribution = $healthInsuranceContribution * $otherFamilyHealthInsurance;
        $period = request()->period ? Carbon::parse('01-'.request()->period)->format('Y-m-d') : date('Y-m-01');
        $attendanceDeduction = $this->payrollRepository->calculateAttendanceDeduction($employeeId, Carbon::parse($period), $employee->position->salary);
        $totalDeduction = $pph21Deduction + $healthInsuranceContribution + $otherFamilyHealthInsuranceContribution;
        $netSalary = $employee->position->salary - $totalDeduction;
        $data = [
            'allowance_pph_21' => 0,
            'deduction_pph_21' => $pph21Deduction,
            'salary' => $employee->position->salary,
            'attendance_deduction' => $attendanceDeduction,
            'total_deduction' =>  $totalDeduction,
            'net_salary' => $netSalary,
            'employment_contract' => $employee->employment_contract,
            'account_number' => $employee->account_number,
            'health_insurance_contribution' => $employee->healthInsurance->contribution,
            'other_family_health_insurance_contribution' => $otherFamilyHealthInsuranceContribution,
            'other_family_health_insurance' => $otherFamilyHealthInsurance
        ];

        if (request()->isJson()) {
            return response()->json([
                'data' => $data
            ]);
        }

        return $data;
    }
}
