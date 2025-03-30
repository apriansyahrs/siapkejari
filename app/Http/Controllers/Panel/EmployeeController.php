<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\HealthInsuranceRepository;
use App\Repositories\PositionRepository;
use App\Repositories\ShiftScheduleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    protected $employeeRepository;
    protected $positionRepository;
    protected $healthInsuranceRepository;
    protected $attendanceRepository;
    protected $shiftScheduleRepository;

    public function __construct(
        EmployeeRepository $employeeRepository,
        PositionRepository $positionRepository,
        HealthInsuranceRepository $healthInsuranceRepository,
        AttendanceRepository $attendanceRepository,
        ShiftScheduleRepository $shiftScheduleRepository
    ) {
        $this->employeeRepository = $employeeRepository;
        $this->positionRepository = $positionRepository;
        $this->healthInsuranceRepository = $healthInsuranceRepository;
        $this->attendanceRepository = $attendanceRepository;
        $this->shiftScheduleRepository = $shiftScheduleRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $employees = $this->employeeRepository->searchWithPagination($keyword, 10);
        } else {
            $employees = $this->employeeRepository->getAllWithPagination(10);
        }

        $positions = $this->positionRepository->getAll();
        $healthInsurances = $this->healthInsuranceRepository->getAll();
        $title = 'Pegawai';
        return view('pages.panel.employee.index', compact('title', 'employees', 'positions', 'healthInsurances'));
    }

    public function show($username)
    {
        $employee = $this->employeeRepository->getByUsername($username);

        if (!$employee) {
            abort(404);
        }

        if (request()->isJson()) {
            $employee->salary = $employee->position->salary;
            return response()->json([
                'data' => $employee
            ]);
        }

        $healthInsurances = $this->healthInsuranceRepository->getAll();
        $positions = $this->positionRepository->getAll();
        $title = $employee->name;
        return view('pages.panel.employee.show', compact('title', 'employee', 'positions', 'healthInsurances'));
    }

    public function store(StoreEmployeeRequest $request)
    {
        $payload = $request->only([
            'name',
            'username',
            'password',
            'nik',
            'email',
            'birth_place',
            'birth_date',
            'position_id',
            'marital_status',
            'npwp',
            'phone_number',
            'health_insurance_number',
            'health_insurance_id',
            'number_of_dependants',
            'account_number',
            'employment_contract',
            'is_active'
        ]);
        $this->employeeRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Pegawai berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateEmployeeRequest $request, $username)
    {
        $payload = $request->only([
            'name',
            'birth_place',
            'birth_date',
            'position_id',
            'marital_status',
            'npwp',
            'phone_number',
            'health_insurance_number',
            'health_insurance_id',
            'number_of_dependants',
            'account_number',
            'employment_contract'
        ]);
        $this->employeeRepository->update($username, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Pegawai berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function activate($username)
    {
        $this->employeeRepository->activate($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Pegawai berhasil diaktifkan');
        return to_route('panel.employee');
    }

    public function deactivate($username)
    {
        $this->employeeRepository->deactivate($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Pegawai berhasil dinonaktifkan');
        return to_route('panel.employee');
    }

    public function destroy($username)
    {
        $employee = $this->employeeRepository->getByUsername($username);
        $isExistsAttendance = $this->attendanceRepository->isExistsByEmployeeId($employee->id);
        $isExistsShiftSchedule = $this->shiftScheduleRepository->isExistsByEmployeeId($employee->id);

        if ($isExistsAttendance || $isExistsShiftSchedule) {
            Session::flash('toast-status', 'danger');
            Session::flash('toast-title', 'Gagal');
            Session::flash('toast-text', 'Pegawai gagal dihapus');
        } else {
            $this->employeeRepository->delete($username);
            Session::flash('toast-status', 'success');
            Session::flash('toast-title', 'Sukses');
            Session::flash('toast-text', 'Pegawai berhasil dihapus');
        }

        return to_route('panel.employee');
    }

    public function resetPassword($username)
    {
        $employee = $this->employeeRepository->getByUsername($username);
        $this->employeeRepository->changePassword($employee->id, $employee->nik);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Password pegawai berhasil direset');
        return to_route('panel.employee');
    }

    public function activateFreeRadius($username)
    {
        $this->employeeRepository->activateFreeRadius($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Radius bebas berhasil diaktifkan');
        return to_route('panel.employee');
    }

    public function deactivateFreeRadius($username)
    {
        $this->employeeRepository->deactivateFreeRadius($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Radius bebas berhasil dinonaktifkan');
        return to_route('panel.employee');
    }
}
