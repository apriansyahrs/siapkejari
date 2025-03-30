<?php

namespace App\Repositories;

use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceRepository
{
    public function getByCheckinDateWithPagination($date, $perPage = 10)
    {
        return Attendance::where('checkin_date', $date)->paginate($perPage);
    }

    public function getById($id)
    {
        return Attendance::find($id);
    }

    public function getByEmployeeIdToday($employeeId)
    {
        return Attendance::where('employee_id', $employeeId)
            ->whereDate('checkin_date', Carbon::today())
            ->orWhere(function ($query) {
                $query->whereDate('checkout_date', Carbon::today());
            })->first();
    }

    public function getByEmployeeIdWithLimit($employeeId, $limit)
    {
        return Attendance::where('employee_id', $employeeId)->orderBy('checkin_date', 'desc')->limit($limit)->get();
    }

    public function getByCheckinPeriod($year, $month)
    {
        return Attendance::whereYear('checkin_date', $year)->whereMonth('checkin_date', $month)->get();
    }

    public function getByEmployeeIdAndCheckinPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)->whereYear('checkin_date', $year)->whereMonth('checkin_date', $month)->get();
    }

    public function getByEmployeeIdAndCheckinDate($employeeId, $checkinDate)
    {
        return Attendance::where('employee_id', $employeeId)->where('checkin_date', $checkinDate)->first();
    }

    public function getByEmployeeIdAndCheckoutDate($employeeId, $checkoutDate)
    {
        return Attendance::where('employee_id', $employeeId)->where('checkout_date', $checkoutDate)->first();
    }

    public function getAttendanceRecap($year, $month)
    {
        return Attendance::select(
            'employee_id',
            DB::raw('SUM(CASE WHEN status = \'Hadir\' THEN 1 ELSE 0 END) as hadir'),
            DB::raw('SUM(CASE WHEN status = \'Izin\' THEN 1 ELSE 0 END) as izin'),
            DB::raw('SUM(CASE WHEN status = \'Sakit\' THEN 1 ELSE 0 END) as sakit'),
            DB::raw('SUM(CASE WHEN status = \'Cuti\' THEN 1 ELSE 0 END) as cuti'),
            DB::raw('SUM(CASE WHEN status = \'Tanpa Keterangan\' THEN 1 ELSE 0 END) as tanpa_keterangan'),
            DB::raw('SUM(CASE WHEN checkout_time IS NULL THEN 1 ELSE 0 END) as tidak_absen_pulang')
        )
        ->whereYear('checkin_date', $year)
        ->whereMonth('checkin_date', $month)
        ->orderBy('employee_id')
        ->groupBy('employee_id')
        ->with('employee:id,name,nik')
        ->get();
    }

    public function create($data)
    {
        Attendance::create($data);
    }

    public function checkoutById($id, $data)
    {
        $this->getById($id)->update($data);
    }

    public function countAbsenceByEmployeeIdThisMonth($employeeId)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', '!=', 'Hadir')
            ->whereYear('checkin_date', Carbon::now()->year)
            ->whereMonth('checkin_date', Carbon::now()->subMonth())
            ->count();
    }

    public function countAttendedByEmployeeIdThisMonth($employeeId)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Hadir')
            ->whereYear('checkin_date', Carbon::now()->year)
            ->whereMonth('checkin_date', Carbon::now()->subMonth())
            ->count();
    }

    public function countAbsenceByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', '!=', 'Hadir')
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function countAttendedByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Hadir')
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function countCheckinLateByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Hadir')
            ->where('checkin_late', '!=', null)
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function countCheckoutEarlyByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Hadir')
            ->where('checkout_early', '!=', null)
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function countSickByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Sakit')
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function countPermissionByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Izin')
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function countWithoutExplanationByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('status', 'Tanpa Keterangan')
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
        }

    public function sumWorkingHourByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('working_hour', '!=', null)
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->sum('working_hour');
    }

    public function countNoAttendanceCheckoutByEmployeeIdAndPeriod($employeeId, $year, $month)
    {
        return Attendance::where('employee_id', $employeeId)
            ->where('checkout_time', null)
            ->where('status', 'Hadir')
            ->whereYear('checkin_date', $year)
            ->whereMonth('checkin_date', $month)
            ->count();
    }

    public function isExistsByEmployeeId($employeeId)
    {
        return Attendance::where('employee_id', $employeeId)->exists();
    }
}
