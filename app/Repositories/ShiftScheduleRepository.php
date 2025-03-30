<?php

namespace App\Repositories;

use App\Models\ShiftSchedule;

class ShiftScheduleRepository
{
    public function getAllWithPagination($perPage = 10)
    {
        return ShiftSchedule::paginate($perPage);
    }

    public function getByDateWithPagination($date, $perPage = 10)
    {
        return ShiftSchedule::where('date', $date)->paginate($perPage);
    }

    public function getByEmployeeIdAndDate($employeeId, $date)
    {
        return ShiftSchedule::where('employee_id', $employeeId)->where('date', $date)->first();
    }

    public function getById($id)
    {
        return ShiftSchedule::find($id);
    }

    public function create($data)
    {
        ShiftSchedule::create($data);
    }

    public function update($id, $data)
    {
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    public function isExistsByEmployeeId($employeeId)
    {
        return ShiftSchedule::where('employee_id', $employeeId)->exists();
    }
}
