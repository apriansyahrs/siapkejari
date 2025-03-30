@extends('layouts.employee')

@section('content')
<h4 class="text-lg font-medium">Attendance History</h4>
@if ($attendances->count() > 0)
@foreach ($attendances as $item)
@php

@endphp
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
                    <p class="font-bold text-gray-700 dark:text-gray-400 text-md">{{ $item->working_hour ? \Carbon\Carbon::createFromTimestamp($item->working_hour * 60)->format('H:i') : '-' }}</p>
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
