@extends('layouts.employee')

@section('content')
<div class="flex items-center gap-2">
    <a href="{{ route('account') }}" class="inline-block">
        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
    </a>
    <h4 class="text-lg font-medium">Change Password</h4>
</div>
<div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 my-2">
    <div class="mb-4">
        <label for="current-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Current Password</label>
        <input type="password" id="current-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#597a6f] focus:border-[#597a6f] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100">
        <small class="text-red-500"></small>
    </div>
    <div class="mb-4">
        <label for="new-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">New Password</label>
        <input type="password" id="new-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#597a6f] focus:border-[#597a6f] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100">
        <small class="text-red-500"></small>
    </div>
    <div class="mb-4">
        <label for="confirmation-password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirmation Password</label>
        <input type="password" id="confirmation-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#597a6f] focus:border-[#597a6f] block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 disabled:bg-gray-100">
        <small class="text-red-500"></small>
    </div>
    <button
        type="button"
        id="submit"
        class="w-full inline-flex items-center text-white bg-[#597a6f] hover:bg-[#4e6b62] focus:ring-4 focus:outline-none focus:ring-[#89bbab] font-medium rounded-lg text-sm px-5 py-2.5 justify-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-[#4e6b62] disabled:opacity-60 gap-2"
    >
        Submit
    </button>
</div>
@endsection

@push('scripts')
<script>
    const currentPasswordInput = document.getElementById('current-password');
    const newPasswordInput = document.getElementById('new-password');
    const confirmationPasswordInput = document.getElementById('confirmation-password');
    const submitButton = document.getElementById('submit');
    const spinnerIcon = '<svg aria-hidden="true" role="status" class="inline w-4 h-4 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/></svg>';
    const csrfToken = '{{ csrf_token() }}';

    submitButton.addEventListener('click', async () => {
        disabledElement();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/account`;
        }

        if (response.errors) {
            showErrors(response.errors)
        }

        enabledElement()
    });

    const enabledElement = () => {
        currentPasswordInput.removeAttribute('disabled');
        newPasswordInput.removeAttribute('disabled');
        confirmationPasswordInput.removeAttribute('disabled');
        submitButton.removeAttribute('disabled');
        submitButton.innerHTML = 'Submit';
    }

    const disabledElement = () => {
        currentPasswordInput.setAttribute('disabled', '');
        newPasswordInput.setAttribute('disabled', '');
        confirmationPasswordInput.setAttribute('disabled', '');
        submitButton.setAttribute('disabled', '');
        submitButton.innerHTML = `${spinnerIcon} Loading`;
    }

    const clearErrors = () => {
        currentPasswordInput.nextElementSibling.textContent = '';
        newPasswordInput.nextElementSibling.textContent = '';
        confirmationPasswordInput.nextElementSibling.textContent = '';
    }

    const showErrors = (errors) => {
        if (errors.current_password) {
            currentPasswordInput.nextElementSibling.textContent = errors.current_password[0];
        }
        if (errors.password) {
            newPasswordInput.nextElementSibling.textContent = errors.password[0];
        }
        if (errors.password_confirmation) {
            confirmationPasswordInput.nextElementSibling.textContent = errors.password_confirmation[0];
        }
    }

    const save = async () => {
        const body = {
            current_password: currentPasswordInput.value,
            password: newPasswordInput.value,
            password_confirmation: confirmationPasswordInput.value,
        };
        const encodedBody = new URLSearchParams(body);
        const options = {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: encodedBody
        }
        const response = await fetch(`${window.location.origin}/change-password`, options);
        const result = await response.json();
        console.log(result);
        return result;
    }
</script>
@endpush
