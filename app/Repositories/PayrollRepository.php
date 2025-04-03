<?php

namespace App\Repositories;

use App\Models\Payroll;
use App\Models\Holiday;
use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PayrollRepository
{
    public function getAllWithPagination($perPage = 10)
    {
        return Payroll::orderBy('period', 'desc')->paginate($perPage);
    }

    public function getByEmployeeIdWithLimit($employeeId, $limit)
    {
        return Payroll::where('employee_id', $employeeId)->orderBy('period', 'desc')->limit($limit)->get();
    }

    public function getByPeriod($period)
    {
        return Payroll::where('period', $period)->get();
    }

    public function getByPeriodWithPagination($period, $perPage = 10)
    {
        return Payroll::where('period', $period)->paginate($perPage);
    }

    public function getByEmployeeIdAndPeriod($employeeId, $period)
    {
        return Payroll::where('employee_id', $employeeId)->where('period', $period)->first();
    }

    public function getById($id)
    {
        return Payroll::find($id);
    }

    public function create($data)
    {
        $period = Carbon::parse('01-'.$data['period']);
        $data['attendance_deduction'] = $this->calculateAttendanceDeduction($data['employee_id'], $period, $data['salary']);
        $data['total_deduction'] = $data['pph_21_deduction'] + $data['health_insurance_contribution'] +
                                  $data['other_family_health_insurance_contribution'] + $data['attendance_deduction'];
        $data['net_salary'] = $data['salary'] - $data['total_deduction'];

        Payroll::create($data);
    }

    public function bulkInsert($data)
    {
        foreach ($data as &$item) {
            $period = Carbon::parse($item['period']);
            $item['attendance_deduction'] = $this->calculateAttendanceDeduction($item['employee_id'], $period, $item['salary']);
            $item['total_deduction'] = $item['pph_21_deduction'] + $item['health_insurance_contribution'] +
                                      $item['other_family_health_insurance_contribution'] + $item['attendance_deduction'];
            $item['net_salary'] = $item['salary'] - $item['total_deduction'];
        }

        Payroll::insert($data);
    }

    public function calculateAttendanceDeduction($employeeId, $period, $salary)
    {
        $startDate = $period->copy()->startOfMonth();
        $endDate = $period->copy()->endOfMonth();
        $dates = CarbonPeriod::create($startDate, $endDate);

        $holidays = Holiday::whereYear('date', $period->year)
            ->whereMonth('date', $period->month)
            ->pluck('date')
            ->map(function($date) {
                return Carbon::parse($date)->format('Y-m-d');
            })
            ->toArray();

        $attendances = Attendance::where('employee_id', $employeeId)
            ->whereDate('checkin_date', '>=', $startDate)
            ->whereDate('checkin_date', '<=', $endDate)
            ->get()
            ->mapWithKeys(function($attendance) {
                return [
                    Carbon::parse($attendance->checkin_date)->format('Y-m-d') => [
                        'checkin_late' => $attendance->checkin_late,
                        'checkout_early' => $attendance->checkout_early
                    ]
                ];
            })
            ->toArray();

        $absenceDays = 0;
        $lateOrEarlyDays = 0;

        foreach ($dates as $date) {
            $isWeekend = $date->isWeekend();
            $isHoliday = in_array($date->format('Y-m-d'), $holidays);
            $hasAttendance = array_key_exists($date->format('Y-m-d'), $attendances);

            if (!$isWeekend && !$isHoliday && !$hasAttendance) {
                $absenceDays++;
            } elseif ($hasAttendance) {
                $attendance = $attendances[$date->format('Y-m-d')];
                if (!is_null($attendance['checkin_late']) || !is_null($attendance['checkout_early'])) {
                    $lateOrEarlyDays++;
                }
            }
        }

        $totalDeductionPercentage = $absenceDays + $lateOrEarlyDays;
        return ($totalDeductionPercentage > 0) ? round($salary * ($totalDeductionPercentage / 100)) : 0;
    }
}
