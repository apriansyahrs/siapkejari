<?php

namespace App\Repositories;

use App\Models\Position;

class PositionRepository
{
    public function getAll()
    {
        return Position::all();
    }

    public function getAllWithPagination($perPage = 10)
    {
        return Position::paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return Position::where('name', 'like', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getById($id)
    {
        return Position::find($id);
    }

    public function create($data)
    {
        Position::create($data);
    }

    public function update($id, $data)
    {
        $this->getById($id)->update($data);
    }

    public function delete($id)
    {
        Position::destroy($id);
    }

    public function activate($id)
    {
        $this->getById($id)->update(['is_active' => true]);
    }

    public function deactivate($id)
    {
        $this->getById($id)->update(['is_active' => false]);
    }

    public function enabledShift($id)
    {
        $this->getById($id)->update(['is_enabled_shift' => true]);
    }

    public function disabledShift($id)
    {
        $this->getById($id)->update(['is_enabled_shift' => false]);
    }
}
