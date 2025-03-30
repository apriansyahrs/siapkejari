<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $userRepository;
    protected $employeeRepository;

    public function __construct(UserRepository $userRepository, EmployeeRepository $employeeRepository)
    {
        $this->userRepository = $userRepository;
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $totalUser = $this->userRepository->countAll();
        $totalEmployee = $this->employeeRepository->countActive();
        $title = 'Dashboard';
        return view('pages.panel.dashboard', compact('title', 'totalUser', 'totalEmployee'));
    }
}
