@extends('layouts.employee')

@section('content')
<div class="flex items-center gap-2">
    <a href="{{ route('account') }}" class="inline-block">
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
    </a>
    <h4 class="text-lg font-medium">Profile</h4>
</div>
<div class="p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-2">
    <div class="flex justify-between">
        <div>
            <p class="text-sm mb-2">NIK</p>
            <p class="text-sm mb-2">Name</p>
            <p class="text-sm mb-2">Username</p>
            <p class="text-sm mb-2">Email</p>
            <p class="text-sm mb-2">Birth Place</p>
            <p class="text-sm mb-2">Birth Date</p>
            <p class="text-sm mb-2">Marital Status</p>
            <p class="text-sm mb-2">NPWP</p>
            <p class="text-sm mb-2">Phone Number</p>
            <p class="text-sm mb-2">Health Insurance Number</p>
            <p class="text-sm mb-2">Account Number</p>
            <p class="text-sm mb-2">Employment Contract</p>
            <p class="text-sm">Number of dependants</p>
        </div>
        <div class="text-right">
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->nik }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->name }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->username }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->email }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->birth_place }}</p>
            <p class="text-sm font-semibold mb-2">{{ \Carbon\Carbon::parse(auth('employee')->user()->birth_date)->format('d-m-Y') }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->marital_status }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->npwp }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->phone_number }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->health_insurance_number }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->account_number }}</p>
            <p class="text-sm font-semibold mb-2">{{ auth('employee')->user()->employment_contract }}</p>
            <p class="text-sm font-semibold">{{ auth('employee')->user()->number_of_dependants }}</p>
        </div>
    </div>
</div>
@endsection
