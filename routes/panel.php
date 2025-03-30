<?php

use App\Http\Controllers\Panel\AttendanceController;
use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\ChangePasswordController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\EmployeeController;
use App\Http\Controllers\Panel\HealthInsuranceController;
use App\Http\Controllers\Panel\HolidayController;
use App\Http\Controllers\Panel\PayrollController;
use App\Http\Controllers\Panel\PositionController;
use App\Http\Controllers\Panel\ProfileController;
use App\Http\Controllers\Panel\ShiftController;
use App\Http\Controllers\Panel\ShiftScheduleController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\WorkingHourController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'index'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('pegawai')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee');
        Route::get('/@{username}', [EmployeeController::class, 'show'])->name('employee.show');
        Route::post('/', [EmployeeController::class, 'store'])->name('employee.store');
        Route::put('/@{username}/reset-password', [EmployeeController::class, 'resetPassword'])->name('employee.reset-password');
        Route::put('/@{username}/radius-bebas/aktifkan', [EmployeeController::class, 'activateFreeRadius'])->name('employee.activate-free-radius');
        Route::put('/@{username}/radius-bebas/nonaktifkan', [EmployeeController::class, 'deactivateFreeRadius'])->name('employee.deactivate-free-radius');
        Route::put('/@{username}/aktifkan', [EmployeeController::class, 'activate'])->name('employee.activate');
        Route::put('/@{username}/nonaktifkan', [EmployeeController::class, 'deactivate'])->name('employee.deactivate');
        Route::put('/@{username}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::delete('/@{username}', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    });
    Route::prefix('presensi')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('attendance');
        Route::get('/{id}', [AttendanceController::class, 'show'])->name('attendance.show');
        Route::post('/', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::post('/rekap', [AttendanceController::class, 'report'])->name('attendance.report');
    });
    Route::prefix('payroll')->group(function () {
        Route::get('/', [PayrollController::class, 'index'])->name('payroll');
        Route::get('/{id}', [PayrollController::class, 'show'])->name('payroll.show');
        Route::post('/', [PayrollController::class, 'store'])->name('payroll.store');
        Route::post('/{id}/unduh', [PayrollController::class, 'download'])->name('payroll.download');
        Route::post('/generate', [PayrollController::class, 'generate'])->name('payroll.generate');
        Route::post('/hitung/{employeeId}', [PayrollController::class, 'calculate'])->name('payroll.calculate');
    });
    Route::prefix('jam-kerja')->group(function () {
        Route::get('/', [WorkingHourController::class, 'index'])->name('working-hour');
        Route::get('/{id}', [WorkingHourController::class, 'show'])->name('working-hour.show');
        Route::post('/', [WorkingHourController::class, 'store'])->name('working-hour.store');
        Route::put('/{id}', [WorkingHourController::class, 'update'])->name('working-hour.update');
        Route::delete('/{id}', [WorkingHourController::class, 'destroy'])->name('working-hour.destroy');
    });
    Route::prefix('shift')->group(function () {
        Route::get('/', [ShiftController::class, 'index'])->name('shift');
        Route::get('/{id}', [ShiftController::class, 'show'])->name('shift.show');
        Route::post('/', [ShiftController::class, 'store'])->name('shift.store');
        Route::put('/{id}/aktifkan', [ShiftController::class, 'activate'])->name('shift.activate');
        Route::put('/{id}/nonaktifkan', [ShiftController::class, 'deactivate'])->name('shift.deactivate');
        Route::put('/{id}', [ShiftController::class, 'update'])->name('shift.update');
        Route::delete('/{id}', [ShiftController::class, 'destroy'])->name('shift.destroy');
    });
    Route::prefix('jadwal-shift')->group(function () {
        Route::get('/', [ShiftScheduleController::class, 'index'])->name('shift-schedule');
        Route::get('/{id}', [ShiftScheduleController::class, 'show'])->name('shift-schedule.show');
        Route::post('/', [ShiftScheduleController::class, 'store'])->name('shift-schedule.store');
        Route::put('/{id}', [ShiftScheduleController::class, 'update'])->name('shift-schedule.update');
        Route::delete('/{id}', [ShiftScheduleController::class, 'destroy'])->name('shift-schedule.destroy');
    });
    Route::prefix('jabatan')->group(function () {
        Route::get('/', [PositionController::class, 'index'])->name('position');
        Route::get('/{id}', [PositionController::class, 'show'])->name('position.show');
        Route::post('/', [PositionController::class, 'store'])->name('position.store');
        Route::put('/{id}/aktifkan', [PositionController::class, 'activate'])->name('position.activate');
        Route::put('/{id}/nonaktifkan', [PositionController::class, 'deactivate'])->name('position.deactivate');
        Route::put('/{id}/aktifkan-shift', [PositionController::class, 'enabledShift'])->name('position.enabled-shift');
        Route::put('/{id}/nonaktifkan-shift', [PositionController::class, 'disabledShift'])->name('position.disabled-shift');
        Route::put('/{id}', [PositionController::class, 'update'])->name('position.update');
        Route::delete('/{id}', [PositionController::class, 'destroy'])->name('position.destroy');
    });
    Route::prefix('hari-libur')->group(function () {
        Route::get('/', [HolidayController::class, 'index'])->name('holiday');
        Route::get('/{id}', [HolidayController::class, 'show'])->name('holiday.show');
        Route::post('/', [HolidayController::class, 'store'])->name('holiday.store');
        Route::put('/{id}', [HolidayController::class, 'update'])->name('holiday.update');
        Route::delete('/{id}', [HolidayController::class, 'destroy'])->name('holiday.destroy');
    });
    Route::prefix('jaminan-kesehatan')->group(function () {
        Route::get('/', [HealthInsuranceController::class, 'index'])->name('health-insurance');
        Route::get('/{id}', [HealthInsuranceController::class, 'show'])->name('health-insurance.show');
        Route::post('/', [HealthInsuranceController::class, 'store'])->name('health-insurance.store');
        Route::put('/{id}', [HealthInsuranceController::class, 'update'])->name('health-insurance.update');
        Route::delete('/{id}', [HealthInsuranceController::class, 'destroy'])->name('health-insurance.destroy');
    });
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user');
        Route::get('/@{username}', [UserController::class, 'show'])->name('user.show');
        Route::post('/', [UserController::class, 'store'])->name('user.store');
        Route::put('/@{username}/aktifkan', [UserController::class, 'activate'])->name('user.activate');
        Route::put('/@{username}/nonaktifkan', [UserController::class, 'deactivate'])->name('user.deactivate');
        Route::put('/@{username}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/@{username}', [UserController::class, 'destroy'])->name('user.destroy');
    });
    Route::prefix('profil')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('profile');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });
    Route::prefix('ganti-password')->group(function () {
        Route::get('/', [ChangePasswordController::class, 'index'])->name('change-password');
        Route::put('/', [ChangePasswordController::class, 'update'])->name('change-password.update');
    });
});
