@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-5">
                            <h2 class="page-title">Jadwal Shift</h2>
                        </div>
                        <div class="col-7 text-end">
                            <form action="{{ route('panel.shift-schedule.destroy', $shiftSchedule->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jadwal shift?')">
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
                            <label class="form-label">Nama Pegawai</label>
                            <p class="mb-0">{{ $shiftSchedule->employee->name }}</p>
                            <div class="my-3">
                                <label for="" class="form-label">Shift</label>
                                <select name="shift" id="" class="form-select">
                                    <option value="">Pilih</option>
                                    @foreach ($shifts as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $shiftSchedule->shift_id ? 'selected' : '' }}>
                                        {{ $item->name }} {{ \Carbon\Carbon::parse($item->checkin_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->checkout_time)->format('H:i') }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-3">
                                <label for="" class="form-label">Tanggal</label>
                                <input type="text" class="form-control" name="date" value="{{ \Carbon\Carbon::parse($shiftSchedule->date)->format('d-m-Y') }}" maxlength="10" autocomplete="off">
                                <div class="invalid-feedback"></div>
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
    const id = '{{ $shiftSchedule->id }}';
    const shiftInput = document.querySelector('select[name="shift"]');
    const dateInput = document.querySelector('input[name="date"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';

    new Datepicker(dateInput, {
        autohide: true,
        format: 'dd-mm-yyyy',
        maxView: 1,
        minDate: new Date(),
    });

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/panel/jadwal-shift`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        shiftInput.setAttribute('disabled', '');
        dateInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        shiftInput.removeAttribute('disabled');
        dateInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.shift_id) {
            shiftInput.classList.add('is-invalid');
            shiftInput.nextElementSibling.textContent = errors.shift_id[0];
        }
        if (errors.date) {
            dateInput.classList.add('is-invalid');
            dateInput.nextElementSibling.nextElementSibling.textContent = errors.date[0];
        }
    };

    const clearErrors = () => {
        shiftInput.classList.remove('is-invalid');
        shiftInput.nextElementSibling.textContent = '';
        dateInput.classList.remove('is-invalid');
        dateInput.nextElementSibling.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            shift_id: shiftInput.value,
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

        const response = await fetch(`${window.location.origin}/panel/jadwal-shift/${id}`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
