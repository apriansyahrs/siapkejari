@extends('layouts.employee')

@section('content')
<div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-4 p-5">
    <div class="text-center">
        <img class="w-16 h-16 rounded-full inline-block ring-2 ring-gray-300" src="https://ui-avatars.com/api/?name={{ urlencode(auth('employee')->user()->name) }}" alt="Rounded avatar">
        <p class="font-semibold text-lg text-zinc-700 mt-2">{{ auth('employee')->user()->name }}</p>
        <p class="font-normal text-sm text-gray-400">{{ auth('employee')->user()->position->name }}</p>
    </div>
</div>
<div class="bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mt-4">
    <div class="grid grid-cols-1">
        <a
            href="{{ route('profile') }}"
            class="w-full flex gap-2 text-zinc-700 bg-white hover:text-zinc-800 font-medium rounded-t-lg text-sm px-5 py-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            stroke-width="2"
            stroke-linecap="round"
            stroke-linejoin="round"
            class="icon icon-tabler icons-tabler-outline icon-tabler-user-circle w-5 h-5"
        >
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
            <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
            <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
        </svg>
            <span>Profile</span>
        </a>
        <a
            href="{{ route('change-password') }}"
            class="w-full flex gap-2 text-zinc-700 bg-white hover:text-zinc-800 font-medium text-sm px-5 py-4 border-b border-t dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-lock-password w-5 h-5"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                <path d="M15 16h.01" />
                <path d="M12.01 16h.01" />
                <path d="M9.02 16h.01" />
            </svg>
            <span>Change Password</span>
        </a>
        <a
            href="{{ route('logout') }}"
            class="w-full flex gap-2 text-red-600 bg-white focus:ring-4 focus:ring-blue-300 font-medium rounded-b-lg text-sm px-5 py-4 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-logout w-5 h-5"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                <path d="M9 12h12l-3 -3" />
                <path d="M18 15l3 -3" />
            </svg>
            <span>Logout</span>
        </a>
    </div>
</div>
@endsection
