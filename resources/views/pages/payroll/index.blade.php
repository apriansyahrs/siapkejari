@extends('layouts.employee')

@section('content')
<h4 class="text-lg font-medium">Payroll</h4>
@if ($payrolls->count() > 0)
@foreach ($payrolls as $item)
<a href="{{ route('payroll.show', $item->id) }}">
    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-2">
        <div class="grid grid-cols-3 gap-5">
            <div class="col-span-1">
                <div class="p-5 bg-[#597a6f] text-center rounded-lg">
                    <p class="m-0 text-xl text-white font-bold">{{ \Carbon\Carbon::parse($item->period)->format('M') }}</p>
                    <p class="m-0 text-sm text-white">{{ \Carbon\Carbon::parse($item->period)->format('Y') }}</p>
                </div>
            </div>
            <div class="col-span-2 flex items-center">
                <div class="flex justify-between w-full">
                    <div class="text-">
                        <p class="text-sm">Net Salary</p>
                        <p class="text-sm mt-2">Payment Date</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-700 dark:text-gray-400 text-sm">Rp{{ number_format($item->net_salary, 0, '', ',') }}</p>
                        <p class="font-bold text-gray-700 dark:text-gray-400 text-sm mt-2">{{ \Carbon\Carbon::parse($item->payment_date)->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</a>
@endforeach
@else
<div class="flex items-center flex-col mt-10 gap-4">
    <img src="{{ asset('assets') }}/no-data.svg" alt="" class="w-1/3">
    <p>No Data Available</p>
</div>
@endif
@endsection
