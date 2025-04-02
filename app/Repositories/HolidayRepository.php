<?php

namespace App\Repositories;

use App\Models\Holiday;

class HolidayRepository
{
    public function getByPeriod($year, $month)
    {
        return Holiday::whereYear('date', $year)->whereMonth('date', $month)->get();
    }

    public function getAllWithPagination($perPage = 10)
    {
        return Holiday::paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return Holiday::where('title', 'ilike', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getById($id)
    {
        return Holiday::find($id);
    }

    public function create($data)
    {
        $data['date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d');
        Holiday::create($data);
    }

    public function update($id, $data)
    {
        $data['date'] = \Carbon\Carbon::createFromFormat('d-m-Y', $data['date'])->format('Y-m-d');
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        Holiday::destroy($id);
    }
}
