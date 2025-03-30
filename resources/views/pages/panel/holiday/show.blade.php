@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-5">
                            <h2 class="page-title">Hari Libur</h2>
                        </div>
                        @if ($holiday->date > date('Y-m-d'))
                        <div class="col-7 text-end">
                            <form action="{{ route('panel.holiday.destroy', $holiday->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-danger"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    data-bs-title="Hapus"
                                    onclick="return confirm('Yakin ingin menghapus hari libur?')"
                                >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </button>
                            </form>
                        </div>
                        @endif
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
                            @if ($holiday->date > date('Y-m-d'))
                            <div class="my-3">
                                <label for="" class="form-label">Judul</label>
                                <input type="text" class="form-control" name="title" value="{{ $holiday->title }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-3">
                                <label for="" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($holiday->date)->format('d-m-Y') }}" maxlength="10" autocomplete="off">
                                <div class="invalid-feedback"></div>
                            </div>
                            <button class="btn btn-primary" id="save" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                                Simpan
                            </button>
                            @else
                            <label for="">Judul</label>
                            <p>{{ $holiday->title }}</p>
                            <label for="">Tanggal</label>
                            <p>{{ \Carbon\Carbon::parse($holiday->date)->format('d-m-Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
@endsection

@if ($holiday->date > date('Y-m-d'))
@push('scripts')
<script>
    const id = '{{ $holiday->id }}';
    const titleInput = document.querySelector('input[name="title"]');
    const dateInput = document.querySelector('input[name="date"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
    const today = new Date();
    const tomorrow = today.setDate(today.getDate() + 1);

    new Datepicker(dateInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxView: 1,
        minDate: tomorrow,
    });

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/panel/hari-libur`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        titleInput.setAttribute('disabled', '');
        dateInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        titleInput.removeAttribute('disabled');
        dateInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.title) {
            titleInput.classList.add('is-invalid');
            titleInput.nextElementSibling.textContent = errors.title[0];
        }
        if (errors.date) {
            dateInput.classList.add('is-invalid');
            dateInput.nextElementSibling.nextElementSibling.textContent = errors.date[0];
        }
    };

    const clearErrors = () => {
        titleInput.classList.remove('is-invalid');
        titleInput.nextElementSibling.textContent = '';
        dateInput.classList.remove('is-invalid');
        dateInput.nextElementSibling.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            title: titleInput.value,
            date: dateInput.value,
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

        const response = await fetch(`${window.location.origin}/panel/hari-libur/${id}`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
@endif
