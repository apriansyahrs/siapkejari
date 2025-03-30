@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-4 col-lg-4">
                            <h2 class="page-title">Jam Kerja</h2>
                        </div>
                        <div class="col-8 col-lg-8 text-end">
                            <form action="{{ route('panel.working-hour.destroy', $workingHour->id) }}" method="post" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jam kerja?')">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="my-3">
                                <label for="" class="form-label">Nama</label>
                                <input type="text" class="form-control" name="name" value="{{ $workingHour->name }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="row my-3">
                                <div class="col-6">
                                    <label for="" class="form-label">Jam Masuk</label>
                                    <input type="time" class="form-control" name="checkin-time" value="{{ \Carbon\Carbon::parse($workingHour->checkin_time)->format('H:i') }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="col-6">
                                    <label for="" class="form-label">Jam Keluar</label>
                                    <input type="time" class="form-control" name="checkout-time" value="{{ \Carbon\Carbon::parse($workingHour->checkout_time)->format('H:i') }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <button class="btn btn-primary" id="save" type="button">
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
    const id = '{{ $workingHour->id }}';
    const nameInput = document.querySelector('input[name="name"]');
    const checkinTimeInput = document.querySelector('input[name="checkin-time"]');
    const checkoutTimeInput = document.querySelector('input[name="checkout-time"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/panel/jam-kerja`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        nameInput.setAttribute('disabled', '');
        checkinTimeInput.setAttribute('disabled', '');
        checkoutTimeInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        nameInput.removeAttribute('disabled');
        checkinTimeInput.removeAttribute('disabled');
        checkoutTimeInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.name) {
            nameInput.classList.add('is-invalid');
            nameInput.nextElementSibling.textContent = errors.name[0];
        }
        if (errors.checkin_time) {
            checkinTimeInput.classList.add('is-invalid');
            checkinTimeInput.nextElementSibling.textContent = errors.checkin_time[0];
        }
        if (errors.checkout_time) {
            checkoutTimeInput.classList.add('is-invalid');
            checkoutTimeInput.nextElementSibling.textContent = errors.checkout_time[0];
        }
    };

    const clearErrors = () => {
        nameInput.classList.remove('is-invalid');
        nameInput.nextElementSibling.textContent = '';
        checkinTimeInput.classList.remove('is-invalid');
        checkinTimeInput.nextElementSibling.textContent = '';
        checkoutTimeInput.classList.remove('is-invalid');
        checkoutTimeInput.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            name: nameInput.value,
            checkin_time: checkinTimeInput.value,
            checkout_time: checkoutTimeInput.value,
        };
        const encodedBody = new URLSearchParams(body);

        const options = {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken,
                'X-HTTP-Method-Override': 'PUT'
            },
            body: encodedBody,
        };

        const response = await fetch(`${window.location.origin}/panel/jam-kerja/${id}`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
