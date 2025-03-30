@extends('layouts.employee')

@section('content')
<style>
    .webcams {
        height: auto !important;
    }
    .webcams video {
        width: 100%;
        height: auto !important;
    }

    .webcams canvas {
        display: none;
        /* width: 100%;
        height: auto !important; */
    }
</style>
<div class="flex items-center gap-2 mb-2">
    <a href="javascript:;" class="inline-block" id="back">
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
    </a>
    @if (!$attendance)
    <h4 class="text-lg font-medium">Check In</h4>
    @endif
    @if ($attendance && $attendance->checkout_time === null)
    <h4 class="text-lg font-medium">Check Out</h4>
    @endif
</div>
<div class="flex">
    <div class="webcams rounded-lg"></div>
</div>
<div id="my_result"></div>
<div id="map" class="min-h-80 mt-3" style="z-index: 0"></div>

<div class="fixed bottom-0 left-0 w-full h-16 py-2 px-3 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="max-w-lg h-full mx-auto">
        <button type="button" id="attendance" class="inline-flex w-full h-full gap-2 items-center text-sm font-semibold text-white justify-center px-5 bg-[#597a6f] dark:hover:bg-gray-800 group rounded-lg disabled:opacity-60" disabled>
            @if (!$attendance)
            Check In
            @endif
            @if ($attendance && $attendance->checkout_time === null)
            Check Out
            @endif
        </button>

    </div>
</div>
<div id="danger-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="danger-modal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-red-500 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"></h3>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dangerModal = document.getElementById('danger-modal');
    const placeLatitude = @json(env('PLACE_LATITUDE'));
    const placeLongitude = @json(env('PLACE_LONGITUDE'));
    const attendance = @json($attendance);
    const attendanceButton = document.getElementById('attendance');
    const backButton = document.getElementById('back');
    const spinnerIcon = '<svg aria-hidden="true" role="status" class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>';

    let method = 'checkin';
    if (attendance && attendance.checkout_time === null) {
        method = 'checkout';
    }

    let base64Photo = null;
    let latitude = null;
    let longitude = null;

    function successCallback (position) {
        latitude = position.coords.latitude;
        longitude = position.coords.longitude;
        const map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 17);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        const marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        const circle = L.circle([placeLatitude, placeLongitude], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 100
        }).addTo(map);
    }

    function errorsCallback() {

    }

    document.addEventListener('DOMContentLoaded', () => {
        Webcam.set({
            height : 480,
            width : 640,
            image_format : 'jpeg',
            jpeg_quality : 80,
        });
        Webcam.attach('.webcams')

        if (navigator.geolocation){
            navigator.geolocation.getCurrentPosition(successCallback, errorsCallback, {
                enableHighAccuracy: true
            })
        }

        Webcam.on('live', () => {
            setTimeout(() => {
                if (latitude && longitude) {
                    attendanceButton.removeAttribute('disabled');
                }
            }, 3000);
        })
    });

    backButton.addEventListener('click', () => {
        Webcam.set('flip_horiz', false);
        Webcam.reset();
        return window.location.href = window.location.origin;
    });

    attendanceButton.addEventListener('click', async () => {
        disabledElement();
        Webcam.snap((data) => {
            base64Photo = data;
        });
        Webcam.freeze();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/home`;
        }

        if (response.message) {
            dangerModal.querySelector('h3').textContent = response.message;
            dangerModalInstance.show();
        }

        Webcam.unfreeze();
        enabledElement();
    });

    const disabledElement = () => {
        attendanceButton.setAttribute('disabled', '');
        attendanceButton.innerHTML = `${spinnerIcon} Loading`;
    }

    const enabledElement = () => {
        attendanceButton.removeAttribute('disabled');
        if (method === 'checkin') {
            attendanceButton.innerHTML = 'Check In';
        } else {
            attendanceButton.innerHTML = 'Check Out';
        }
    }

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            latitude,
            longitude,
            photo: base64Photo,
        };
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
            },
            body: JSON.stringify(body),
        };
        const response = await fetch(`${window.location.origin}/attendance/${method}`, options);
        const result = await response.json();
        return result;
    }
</script>
@endpush
