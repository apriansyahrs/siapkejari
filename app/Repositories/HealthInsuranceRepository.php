<?php

namespace App\Repositories;

use App\Models\HealthInsurance;

class HealthInsuranceRepository
{
    public function getAll()
    {
        return HealthInsurance::orderBy('created_at', 'asc')->get();
    }

    public function getAllWithPagination($perPage = 10)
    {
        return HealthInsurance::orderBy('created_at', 'asc')->paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return HealthInsurance::where('class', 'like', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getById($id)
    {
        return HealthInsurance::find($id);
    }

    public function create($data)
    {
        return HealthInsurance::create($data);
    }

    public function update($id, $data)
    {
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        HealthInsurance::destroy($id);
    }
}
