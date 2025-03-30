@extends('layouts.employee')

@section('content')
<div class="mb-4">
    <p>Hi,</p>
    <p class="font-bold">{{ auth('employee')->user()->name }}</p>
</div>
<div class="grid grid-cols-2 gap-3">
    <div class="max-w-sm px-6 py-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <p class="text-sm font-medium tracking-tight text-gray-900 dark:text-white">Check In</p>
        @if ($attendance && $attendance->checkin_time && $attendance->status === 'Hadir')
        <p class="text-xs text-gray-400 mb-1">{{ $attendance->checkin_late ? 'Late' : 'On Time' }}</p>
        <p class="text-2xl font-bold text-gray-700 dark:text-gray-400">{{ \Carbon\Carbon::parse($attendance->checkin_time)->format('H:i') }}</p>
        @else
        <p class="text-xs text-gray-400 mb-1">Not Yet</p>
        <p class="text-2xl font-bold text-gray-400 dark:text-gray-400">{{ $checkinTimeSchedule }}</p>
        @endif
    </div>
    <div class="max-w-sm px-6 py-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <p class="text-sm font-medium tracking-tight text-gray-900 dark:text-white">Check Out</p>
        @if ($attendance && $attendance->checkout_time && $attendance->status === 'Hadir')
        <p class="text-xs text-gray-400 mb-1">{{ $attendance->checkout_early ? 'Early' : 'On Time' }}</p>
        <p class="text-2xl font-bold text-gray-700 dark:text-gray-400">{{ \Carbon\Carbon::parse($attendance->checkout_time)->format('H:i') }}</p>
        @else
        <p class="text-xs text-gray-400 mb-1">Not Yet</p>
        <p class="text-2xl font-bold text-gray-400 dark:text-gray-400">{{ $checkoutTimeSchedule }}</p>
        @endif
    </div>
    <div class="max-w-sm px-6 py-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <p class="text-sm font-medium tracking-tight text-gray-900 dark:text-white">Absence</p>
        <p class="text-xs text-gray-400 mb-1">{{ \Carbon\Carbon::now()->format('F') }}</p>
        <p class="text-2xl font-bold text-gray-700 dark:text-gray-400">{{ $totalAbsence }} <span class="font-normal text-xs">Day</span></p>
    </div>
    <div class="max-w-sm px-6 py-3 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <p class="text-sm font-medium tracking-tight text-gray-900 dark:text-white">Total Attended</p>
        <p class="text-xs text-gray-400 mb-1">{{ \Carbon\Carbon::now()->format('F') }}</p>
        <p class="text-2xl font-bold text-gray-700 dark:text-gray-400">{{ $totalAttended }} <span class="font-normal text-xs">Day</span></p>
    </div>
</div>
<div class="flex justify-between items-center mt-4">
    <h4 class="text-lg font-medium">Attendance History</h4>
    <a href="{{ route('attendance') }}" class="text-sm font-semibold">See More</a>
</div>
@if ($attendanceHistories->count() > 0)
@foreach ($attendanceHistories as $item)
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-2">
    <div class="grid grid-cols-4 gap-2">
        <div class="col-span-1">
            <div class="p-5 bg-[#597a6f] text-center rounded-lg">
                <p class="m-0 text-xl text-white font-bold">{{ \Carbon\Carbon::parse($item->checkin_date)->format('d') }}</p>
                <p class="m-0 text-sm text-white">{{ \Carbon\Carbon::parse($item->checkin_date)->format('D') }}</p>
            </div>
        </div>
        <div class="col-span-3 flex items-center justify-center">
            @if ($item->status === 'Hadir')
            <div class="flex gap-4">
                <div class="text-center">
                    <p class="font-bold text-gray-700 dark:text-gray-400 text-md">{{ \Carbon\Carbon::parse($item->checkin_time)->format('H:i') }}</p>
                    <p class="text-xs">Check In</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-gray-700 dark:text-gray-400 text-md">{{ $item->checkout_time ? \Carbon\Carbon::parse($item->checkout_time)->format('H:i') : '-' }}</p>
                    <p class="text-xs">Check Out</p>
                </div>
                <div class="text-center">
                    <p class="font-bold text-gray-700 dark:text-gray-400 text-md">{{ $item->checkout_time ? \Carbon\Carbon::parse($item->checkin_time)->diff(\Carbon\Carbon::parse($item->checkout_time))->format('%H:%I') : '-' }}</p>
                    <p class="text-xs">Total Hours</p>
                </div>
            </div>
            @else
            <div class="flex">
                <div class="text-center">
                    <p class="font-bold text-gray-700 dark:text-gray-400 text-md">{{ $item->status }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
@else
<div class="flex items-center flex-col mt-10 gap-4">
    <img src="{{ asset('assets') }}/no-data.svg" alt="" class="w-1/3">
    <p>No Data Available</p>
</div>
@endif
@endsection
