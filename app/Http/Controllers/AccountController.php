<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $title = 'Account';
        return view('pages.account', compact('title'));
    }
}
