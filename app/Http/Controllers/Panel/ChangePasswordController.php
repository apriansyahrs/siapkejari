<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $title = 'Ganti Password';
        return view('pages.panel.change-password', compact('title'));
    }

    public function update(ChangePasswordRequest $request)
    {
        $this->userRepository->changePassword(auth()->user()->id, $request->password);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
