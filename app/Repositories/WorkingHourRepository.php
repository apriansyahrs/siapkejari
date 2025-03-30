<?php

namespace App\Repositories;

use App\Models\WorkingHour;

class WorkingHourRepository
{
    public function getAll()
    {
        return WorkingHour::all();
    }

    public function getAllWithPagination($perPage)
    {
        return WorkingHour::paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return WorkingHour::where('name', 'like', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getById($id)
    {
        return WorkingHour::find($id);
    }

    public function create($data)
    {
        WorkingHour::create($data);
    }

    public function update($id, $data)
    {
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
    }
}
