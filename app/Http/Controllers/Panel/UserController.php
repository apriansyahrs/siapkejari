<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $users = $this->userRepository->searchWithPagination($keyword, 10);
        } else {
            $users = $this->userRepository->getAllWithPagination(10);
        }

        $title = 'User';
        return view('pages.panel.user.index', compact('title', 'users'));
    }

    public function show($username)
    {
        $user = $this->userRepository->getByUsername($username);

        if (!$user) {
            abort(404);
        }

        $title = $user->username;
        return view('pages.panel.user.show', compact('title', 'user'));
    }

    public function store(StoreUserRequest $request)
    {
        $payload = $request->only(['name', 'username', 'password', 'role', 'is_active']);
        $this->userRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'User berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateUserRequest $request, $username)
    {
        $payload = $request->only(['name']);
        $this->userRepository->update($username, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'User berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function activate($username)
    {
        $this->userRepository->activate($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'User berhasil diaktifkan');
        return to_route('panel.user');
    }

    public function deactivate($username)
    {
        $this->userRepository->deactivate($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'User berhasil dinonaktikan');
        return to_route('panel.user');
    }

    public function destroy($username)
    {
        $this->userRepository->delete($username);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'User berhasil dihapus');
        return to_route('panel.user');
    }
}
