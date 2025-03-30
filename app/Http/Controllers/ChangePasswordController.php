<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordEmployeeRequest;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ChangePasswordController extends Controller
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $title = 'Change Password';
        return view('pages.change-password', compact('title'));
    }

    public function update(ChangePasswordEmployeeRequest $request)
    {
        $this->employeeRepository->changePassword(auth('employee')->user()->id, $request->password);
        Session::flash('toast-status', 'success');
        Session::flash('toast-text', 'Password has been updated.');
        return response()->json([
            'status' => 'success'
        ]);
    }
}
