@extends('layouts.panel.main')

@push('styles')
<style>
    .form-selectgroup-input:disabled+.form-selectgroup-label {
        background-color: #f6f8fb !important;
        cursor: default;
    }
    .form-selectgroup-input[disabled][checked]+.form-selectgroup-label {
        border-color: rgba(32, 107, 196, .5)
    }
    .form-selectgroup-input[disabled][checked]+.form-selectgroup-label .form-selectgroup-check {
        background-color: rgba(32, 107, 196, .5)
    }
    .form-selectgroup-boxes .form-selectgroup-input:disabled+.form-selectgroup-label .form-selectgroup-title {
        opacity: .7;
    }
</style>
@endpush

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Hari Libur</h2>
                </div>
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                            Tambah
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-block">
                            <form action="{{ route('panel.holiday') }}" method="get">
                                <div class="row align-items-end">
                                    <div class="col-12 col-lg-3 mb-2 mb-lg-0">
                                        <label for="" class="col-form-label">Kata Kunci</label>
                                        <input type="text" class="form-control" name="keyword" value="{{ request()->keyword }}" placeholder="masukkan kata kunci..." autocomplete="off">
                                    </div>
                                    <div class="col-12 col-lg-1">
                                        <div class="d-grid">
                                            <button class="btn btn-primary" type="submit">
                                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="#ffffff"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                Cari
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th style="width: 1%;">No</th>
                                        <th>Judul</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($holidays->count() > 0)
                                    @foreach ($holidays as $index => $item)
                                    <tr>
                                        <td>{{ ($holidays->currentpage()-1) * $holidays->perpage() + $index + 1 }}</td>
                                        <td>
                                            <a href="{{ route('panel.holiday.show', $item->id) }}">{{ $item->title }}</a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3">Tidak ada data</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if ($holidays->total() > $holidays->perPage())
                        <div class="px-3 mt-3">
                            {{ $holidays->withQueryString()->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.panel._copyright')
</div>
<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hari Libur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" name="title">
                    <div class="invalid-feedback"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="text" class="form-control" name="date" maxlength="10" autocomplete="off">
                    <div class="invalid-feedback"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="save" type="button" class="btn btn-primary ms-auto">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const titleInput = document.querySelector('input[name="title"]');
    const dateInput = document.querySelector('input[name="date"]');
    const saveButton = document.getElementById('save');
    const closeButton = document.querySelector('button.btn-close');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';
    const csrfToken = '{{ csrf_token() }}';
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
            return location.reload();
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
        closeButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        titleInput.removeAttribute('disabled');
        dateInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        closeButton.removeAttribute('disabled');
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
            },
            body: encodedBody,
        };

        const response = await fetch(`${window.location.origin}/panel/hari-libur`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
