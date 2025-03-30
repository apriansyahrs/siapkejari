<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShiftRequest;
use App\Http\Requests\UpdateShiftRequest;
use App\Repositories\ShiftRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShiftController extends Controller
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $shifts = $this->shiftRepository->searchWithPagination($keyword, 10);
        } else {
            $shifts = $this->shiftRepository->getAllWithPagination(10);
        }

        $title = 'Shift';
        return view('pages.panel.shift.index', compact('title', 'shifts'));
    }

    public function show($id)
    {
        $shift = $this->shiftRepository->getById($id);

        if (!$shift) {
            abort(404);
        }

        $title = $shift->name;
        return view('pages.panel.shift.show', compact('title', 'shift'));
    }

    public function store(StoreShiftRequest $request)
    {
        $payload = $request->only(['name', 'checkin_time', 'checkout_time', 'is_active']);
        $this->shiftRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Shift berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateShiftRequest $request, $id)
    {
        $payload = $request->only(['name', 'checkin_time', 'checkout_time']);
        $this->shiftRepository->update($id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Shift berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->shiftRepository->delete($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Shift berhasil dihapus');
        return to_route('panel.shift');
    }

    public function activate($id)
    {
        $this->shiftRepository->activate($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Shift berhasil diaktifkan');
        return to_route('panel.shift');
    }

    public function deactivate($id)
    {
        $this->shiftRepository->deactivate($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Shift berhasil dinonaktifkan');
        return to_route('panel.shift');
    }
}
