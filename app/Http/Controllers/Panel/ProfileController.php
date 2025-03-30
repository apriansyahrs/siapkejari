<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $title = 'Profil';
        return view('pages.panel.profile', compact('title'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $payload = $request->only(['name']);
        $this->userRepository->update(auth()->user()->username, $payload);
        return response()->json([
            'status' => 'success'
        ]);
    }
}
