@extends('layouts.employee')

@section('content')
<div class="flex justify-between gap-2">
    <div class="flex gap-2 items-center">
        <a href="{{ route('payroll') }}" class="inline-block">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
        </a>
        <h4 class="text-lg font-medium">Payroll</h4>
    </div>
    <form action="{{ route('payroll.download', $payroll->id) }}" method="post">
        @csrf
        <button type="submit" id="download">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>
        </button>
    </form>
</div>
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-2">
    <div class="flex justify-between">
        <div>
            <p class="text-sm mb-2">Period</p>
            <p class="text-sm mb-2">Salary</p>
            <p class="text-sm mb-2">Allowance Pph 21</p>
            <p class="text-sm mb-2">Deduction Pph 21</p>
            <p class="text-sm mb-2">Health Insurance Contribution</p>
            <p class="text-sm mb-2">Health Insurance Contribution Other Family</p>
            <p class="text-sm mb-2">Total Deduction</p>
            <p class="text-sm mb-2">Net Salary</p>
            <p class="text-sm mb-2">Account Number</p>
            <p class="text-sm">Payment Date</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-semibold mb-2">{{ \Carbon\Carbon::parse($payroll->period)->format('F Y') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->salary, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->pph_21_allowance, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->pph_21_deduction, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->health_insurance_contribution, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->other_family_health_insurance_contribution, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->total_deduction, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">Rp. {{ number_format($payroll->net_salary, 0, '', ',') }}</p>
            <p class="text-sm font-semibold mb-2">{{ $payroll->account_number }}</p>
            <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($payroll->payment_date)->format('d-m-Y') }}</p>
        </div>
    </div>
</div>
@endsection
