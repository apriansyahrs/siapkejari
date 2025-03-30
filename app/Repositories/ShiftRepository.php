<?php

namespace App\Repositories;

use App\Models\Shift;

class ShiftRepository
{
    public function getAll()
    {
        return Shift::all();
    }

    public function getAllWithPagination($perPage = 10)
    {
        return Shift::paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return Shift::where('name', 'like', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getById($id)
    {
        return Shift::find($id);
    }

    public function create($data)
    {
        Shift::create($data);
    }

    public function update($id, $data)
    {
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
    }

    public function activate($id)
    {
        $this->getById($id)->update(['is_active' => true]);
    }

    public function deactivate($id)
    {
        $this->getById($id)->update(['is_active' => false]);
    }
}
