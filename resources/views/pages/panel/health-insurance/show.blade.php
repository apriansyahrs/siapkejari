@extends('layouts.panel.horizontal')

@section('content')
<div class="page-wrapper">
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 justify-content-center">
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-7">
                            <h2 class="page-title">Jaminan Kesehatan</h2>
                        </div>
                        <div class="col-5 text-end">
                            <form action="{{ route('panel.health-insurance.destroy', $healthInsurance->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus jaminan kesehatan?')">
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
                                <label for="" class="form-label">Kelas</label>
                                <input type="text" class="form-control" name="class" value="{{ $healthInsurance->class }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="my-3">
                                <label for="" class="form-label">Iuran <small>(Rp)</small></label>
                                <input type="text" class="form-control" name="contribution" value="{{ $healthInsurance->contribution }}">
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
    const id = '{{ $healthInsurance->id }}';
    const classInput = document.querySelector('input[name="class"]');
    const contributionInput = document.querySelector('input[name="contribution"]');
    const saveButton = document.getElementById('save');
    const plusIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>';
    const spinnerIcon = '<div class="spinner-border spinner-border-sm me-2" role="status"></div>';

    saveButton.addEventListener('click', async () => {
        disabledElement();
        clearErrors();

        const response = await save();

        if (response.status === 'success') {
            return window.location.href = `${window.location.origin}/panel/jaminan-kesehatan`;
        }

        if (response.errors) {
            showErrors(response.errors);
        }

        enabledElement();
    });

    const disabledElement = () => {
        classInput.setAttribute('disabled', '');
        contributionInput.setAttribute('disabled', '');
        saveButton.setAttribute('disabled', '');
        saveButton.innerHTML = `${spinnerIcon} Loading`;
    };

    const enabledElement = () => {
        classInput.removeAttribute('disabled');
        contributionInput.removeAttribute('disabled');
        saveButton.removeAttribute('disabled');
        saveButton.innerHTML = `${plusIcon} Simpan`;
    };

    const showErrors = (errors) => {
        if (errors.class) {
            classInput.classList.add('is-invalid');
            classInput.nextElementSibling.textContent = errors.class[0];
        }
        if (errors.contribution) {
            contributionInput.classList.add('is-invalid');
            contributionInput.nextElementSibling.textContent = errors.contribution[0];
        }
    };

    const clearErrors = () => {
        classInput.classList.remove('is-invalid');
        classInput.nextElementSibling.textContent = '';
        contributionInput.classList.remove('is-invalid');
        contributionInput.nextElementSibling.textContent = '';
    };

    const save = async () => {
        const csrfToken = '{{ csrf_token() }}';
        const body = {
            class: classInput.value,
            contribution: contributionInput.value,
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

        const response = await fetch(`${window.location.origin}/panel/jaminan-kesehatan/${id}`, options);
        const result = await response.json();
        return result;
    };
</script>
@endpush
