<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="grid h-full max-w-lg grid-cols-5 mx-auto font-medium">
        <a href="{{ route('home') }}" class="inline-flex flex-col items-center justify-center px-5 {{ request()->is('home') ? 'bg-zinc-50 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }} group">
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
                class="icon icon-tabler icons-tabler-outline icon-tabler-home w-6 h-6 mb-1 {{ request()->is('home') ? 'text-zinc-800 dark:text-zinc-700' : 'text-gray-500 dark:text-gray-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-700' }}"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
            </svg>
        </a>
        <a href="{{ route('attendance') }}" class="inline-flex flex-col items-center justify-center px-5 {{ request()->is('attendance') ? 'bg-gray-50 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }} group">
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
                class="icon icon-tabler icons-tabler-outline icon-tabler-history w-6 h-6 mb-1 {{ request()->is('attendance') ? 'text-zinc-800 dark:text-zinc-700' : 'text-gray-500 dark:text-gray-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-700' }}"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 8l0 4l2 2" />
                <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
            </svg>
        </a>
        <a href="{{ route('attendance.create') }}" class="inline-flex flex-col items-center justify-center px-5 relative">
            <div class="bg-[#597a6f] group p-4 rounded-full absolute bottom-6">
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
                    class="icon icon-tabler icons-tabler-outline icon-tabler-user-scan w-8 h-8 text-white dark:text-white"
                >
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10 9a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                    <path d="M4 8v-2a2 2 0 0 1 2 -2h2" />
                    <path d="M4 16v2a2 2 0 0 0 2 2h2" />
                    <path d="M16 4h2a2 2 0 0 1 2 2v2" />
                    <path d="M16 20h2a2 2 0 0 0 2 -2v-2" />
                    <path d="M8 16a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2" />
                </svg>
            </div>
        </a>
        <a href="{{ route('payroll') }}" class="inline-flex flex-col items-center justify-center px-5 {{ request()->is('payroll') ? 'bg-gray-50 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }} group">
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
                class="icon icon-tabler icons-tabler-outline icon-tabler-coins w-6 h-6 mb-1 {{ request()->is('payroll') ? 'text-zinc-800 dark:text-zinc-700' : 'text-gray-500 dark:text-gray-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-700' }}"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z" />
                <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4" />
                <path d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z" />
                <path d="M3 6v10c0 .888 .772 1.45 2 2" />
                <path d="M3 11c0 .888 .772 1.45 2 2" />
            </svg>
        </a>
        <a href="{{ route('account') }}" class="inline-flex flex-col items-center justify-center px-5 {{ request()->is('account') ? 'bg-gray-50 dark:bg-gray-800' : 'hover:bg-gray-50 dark:hover:bg-gray-800' }} group">
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
                class="icon icon-tabler icons-tabler-outline icon-tabler-user w-6 h-6 mb-1 {{ request()->is('account') ? 'text-zinc-800 dark:text-zinc-700' : 'text-gray-500 dark:text-gray-400 group-hover:text-zinc-800 dark:group-hover:text-zinc-700' }}"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
            </svg>
        </a>
    </div>
</div>
