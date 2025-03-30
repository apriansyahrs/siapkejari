<?php

namespace App\Http\Controllers;

use App\Repositories\PayrollRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    protected $payrollRepository;

    public function __construct(PayrollRepository $payrollRepository)
    {
        $this->payrollRepository = $payrollRepository;
    }

    public function index()
    {
        $payrolls = $this->payrollRepository->getByEmployeeIdWithLimit(auth('employee')->user()->id, 10);
        $title = 'Payroll';
        return view('pages.payroll.index', compact('title', 'payrolls'));
    }

    public function show($id)
    {
        $payroll = $this->payrollRepository->getById($id);

        if (!$payroll) {
            abort(404);
        }

        if ($payroll->employee_id !== auth('employee')->user()->id) {
            abort(403);
        }

        $title = 'Payroll Period '.Carbon::parse($payroll->period)->format('F Y');
        return view('pages.payroll.show', compact('title', 'payroll'));
    }

    public function download($id)
    {
        $payroll = $this->payrollRepository->getById($id);

        if (!$payroll) {
            abort(404);
        }

        if ($payroll->employee_id !== auth('employee')->user()->id) {
            abort(403);
        }

        $filename = 'Slip Gaji Pegawai - '.$payroll->employee->name.'_'.Carbon::parse($payroll->period)->translatedFormat('F Y').'.pdf';
        $pdf = Pdf::loadView('printed.payroll.single', ['payroll' => $payroll]);
        return $pdf->download($filename);
    }
}
