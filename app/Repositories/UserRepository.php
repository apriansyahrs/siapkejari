<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAllWithPagination($perPage = 10)
    {
        return User::paginate($perPage);
    }

    public function searchWithPagination($keyword, $perPage = 10)
    {
        return User::where('username', 'like', '%'.$keyword.'%')->orWhere('name', 'like', '%'.$keyword.'%')->paginate($perPage);
    }

    public function getByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    public function create($data)
    {
        User::create($data);
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
        $hashedPassword = Hash::make($password);
        User::where('id', $id)->update(['password' => $hashedPassword]);
    }

    public function countAll()
    {
        return User::count();
    }
}
