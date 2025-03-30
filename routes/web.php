<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('home');
});

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth:employee'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::prefix('attendance')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance');
        Route::get('/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/checkin', [AttendanceController::class, 'checkin'])->name('attendance.checkin');
        Route::post('/checkout', [AttendanceController::class, 'checkout'])->name('attendance.checkout');
    });
    Route::prefix('payroll')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('payroll');
        Route::get('/{id}', [PayrollController::class, 'show'])->name('payroll.show');
        Route::post('/{id}/download', [PayrollController::class, 'download'])->name('payroll.download');
    });
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::prefix('change-password')->group(function () {
        Route::get('/', [ChangePasswordController::class, 'index'])->name('change-password');
        Route::put('/', [ChangePasswordController::class, 'update'])->name('change-password.update');
    });
});