<?php

namespace App\Repositories;

use App\Models\Payroll;

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
        Payroll::create($data);
    }

    public function bulkInsert($data)
    {
        Payroll::insert($data);
    }
}
