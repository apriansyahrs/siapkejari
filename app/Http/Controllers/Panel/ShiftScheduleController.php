<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShiftScheduleRequest;
use App\Http\Requests\UpdateShiftScheduleRequest;
use App\Repositories\EmployeeRepository;
use App\Repositories\ShiftRepository;
use App\Repositories\ShiftScheduleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShiftScheduleController extends Controller
{
    protected $shiftScheduleRepository;
    protected $shiftRepository;
    protected $employeeRepository;

    public function __construct(
        ShiftScheduleRepository $shiftScheduleRepository,
        ShiftRepository $shiftRepository,
        EmployeeRepository $employeeRepository
    ) {
        $this->shiftScheduleRepository = $shiftScheduleRepository;
        $this->shiftRepository = $shiftRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $date = request()->date_filter ? Carbon::parse(request()->date_filter)->format('Y-m-d') : date('d-m-Y');

        if ($date) {
            $shiftSchedules = $this->shiftScheduleRepository->getByDateWithPagination($date, 10);
        } else {
            $shiftSchedules = $this->shiftScheduleRepository->getAllWithPagination(10);
        }

        $shifts = $this->shiftRepository->getAll();
        $employees = $this->employeeRepository->getAll();
        $title = 'Jadwal Shift';
        return view('pages.panel.shift-schedule.index', compact('title', 'shiftSchedules', 'shifts', 'employees', 'date'));
    }

    public function show($id)
    {
        $shiftSchedule = $this->shiftScheduleRepository->getById($id);

        if (!$shiftSchedule) {
            abort(404);
        }
        if ($shiftSchedule->date < date('Y-m-d')) {
            abort(403);
        }

        $shifts = $this->shiftRepository->getAll();
        $title = 'Jadwal Shift';
        return view('pages.panel.shift-schedule.show', compact('title', 'shiftSchedule', 'shifts'));
    }

    public function store(StoreShiftScheduleRequest $request)
    {
        $payload = $request->only(['employee_id', 'shift_id', 'date']);
        $this->shiftScheduleRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jadwal shift berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateShiftScheduleRequest $request, $id)
    {
        $payload = $request->only(['shift_id', 'date']);
        $payload['date'] = Carbon::parse($payload['date'])->format('Y-m-d');
        $this->shiftScheduleRepository->update($id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jadwal shift berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->shiftScheduleRepository->delete($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jadwal shift berhasil dihapu');
        return to_route('panel.shift-schedule');
    }
}
