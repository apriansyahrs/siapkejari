<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('pages.panel.login');
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->only(['username', 'password']);
        $credentials['is_active'] = true;
        $rememberMe = $request->remember_me ?: false;

        if (auth('web')->attempt($credentials, $rememberMe)) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'failed',
            'error' => 'Username atau password salah'
        ]);
    }

    public function logout()
    {
        auth('web')->logout();
        return to_route('panel.login');
    }
}
