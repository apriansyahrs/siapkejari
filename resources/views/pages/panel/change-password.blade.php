@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-5">
                    <h2 class="page-title">Ganti Password</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" class="form-control" name="old-password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-control" name="password">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-control" name="password-confirmation">
                                <div class="invalid-feedback"></div>
                            </div>
                            <button id="save" class="btn btn-primary" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
@endsection

@push('scripts')
<script>
    const oldPasswordInput = document.querySelector('input[name="old-password"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmationPasswordInput = document.querySelector('input[name="password-confirmation"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/panel/dashboard`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        oldPasswordInput.setAttribute('disabled', '');
        passwordInput.setAttribute('disabled', '');
        confirmationPasswordInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        oldPasswordInput.removeAttribute('disabled');
        passwordInput.removeAttribute('disabled');
        confirmationPasswordInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.old_password) {
            oldPasswordInput.classList.add('is-invalid');
            oldPasswordInput.nextElementSibling.textContent = errors.old_password;
        }
        if (errors.password) {
            passwordInput.classList.add('is-invalid');
            passwordInput.nextElementSibling.textContent = errors.password;
        }
        if (errors.password_confirmation) {
            confirmationPasswordInput.classList.add('is-invalid');
            confirmationPasswordInput.nextElementSibling.textContent = errors.password_confirmation;
        }
    };

    const clearErrors = () => {
        oldPasswordInput.classList.remove('is-invalid');
        oldPasswordInput.nextElementSibling.textContent = '';
        passwordInput.classList.remove('is-invalid');
        passwordInput.nextElementSibling.textContent = '';
        confirmationPasswordInput.classList.remove('is-invalid');
        confirmationPasswordInput.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            old_password: oldPasswordInput.value,
            password: passwordInput.value,
            password_confirmation: confirmationPasswordInput.value,
        };
        const encodedBody = new URLSearchParams(body);
        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT',
            },
            body: encodedBody,
        };

        const response = await fetch(`${window.location.origin}/panel/ganti-password`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
