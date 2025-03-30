<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.login');
    }

    public function authenticate(Request $request)
    {
        $credential = $request->only([
            'username',
            'password'
        ]);
        $credential['is_active'] = 1;

        if (auth('employee')->attempt($credential)) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'error' => 'invalid credentials'
        ]);
    }

    public function logout()
    {
        auth('employee')->logout();
        return to_route('login');
    }
}
