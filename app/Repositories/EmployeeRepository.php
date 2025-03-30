<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function getAll()
    {
        return Employee::all();
    }

    public function getActive()
    {
        return Employee::active()->get();
    }

    public function getAllWithPagination($perPage = 10)
    {
        return Employee::paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return Employee::where('name', 'ilike', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getById($id)
    {
        return Employee::find($id);
    }

    public function getByUsername($username)
    {
        return Employee::where('username', $username)->first();
    }

    public function create($data)
    {
        Employee::create($data);
    }

    public function update($username, $data)
    {
        $this->getByUsername($username)->update($data);
    }

    public function delete($username)
    {
        $this->getByUsername($username)->delete();
    }

    public function activate($username)
    {
        $this->getByUsername($username)->update(['is_active' => true]);
    }

    public function deactivate($username)
    {
        $this->getByUsername($username)->update(['is_active' => false]);
    }

    public function changePassword($id, $password)
    {
        $this->getById($id)->update(['password' => $password]);
    }

    public function countActive()
    {
        return Employee::where('is_active', true)->count();
    }

    public function activateFreeRadius($username)
    {
        $this->getByUsername($username)->update(['is_free_radius' => true]);
    }

    public function deactivateFreeRadius($username)
    {
        $this->getByUsername($username)->update(['is_free_radius' => false]);
    }
}
