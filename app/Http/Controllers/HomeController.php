<?php

namespace App\Http\Controllers;

use App\Repositories\AttendanceRepository;
use App\Repositories\ShiftScheduleRepository;
use App\Repositories\WorkingHourRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $attendanceRepository;
    protected $workingHourRepository;
    protected $shiftScheduleRepository;

    public function __construct(
        AttendanceRepository $attendanceRepository,
        WorkingHourRepository $workingHourRepository,
        ShiftScheduleRepository $shiftScheduleRepository
    ) {
        $this->attendanceRepository = $attendanceRepository;
        $this->workingHourRepository = $workingHourRepository;
        $this->shiftScheduleRepository = $shiftScheduleRepository;
    }

    public function index()
    {
        $title = 'Home';
        $user = auth('employee')->user();
        $attendance = $this->attendanceRepository->getByEmployeeIdToday($user->id);
        $attendanceHistories = $this->attendanceRepository->getByEmployeeIdWithLimit($user->id, 5);

        if ($user->position->is_enabled_shift) {
            $shiftSchedule = $this->shiftScheduleRepository->getByEmployeeIdAndDate($user->id, date('Y-m-d'));
            $checkinTimeSchedule = 'Not Set';
            $checkoutTimeSchedule = 'Not Set';
            if ($shiftSchedule) {
                $checkinTimeSchedule = Carbon::parse($shiftSchedule->shift->checkin_time)->format('H:i');
                $checkoutTimeSchedule = Carbon::parse($shiftSchedule->shift->checkout_time)->format('H:i');
            }
        } else {
            $workingHour = $this->workingHourRepository->getById($user->position->working_hour_id);
            $checkinTimeSchedule = Carbon::parse($workingHour->checkin_time)->format('H:i');
            $checkoutTimeSchedule = Carbon::parse($workingHour->checkout_time)->format('H:i');
        }

        $totalAbsence = $this->attendanceRepository->countAbsenceByEmployeeIdThisMonth($user->id);
        $totalAttended = $this->attendanceRepository->countAttendedByEmployeeIdThisMonth($user->id);
        return view('pages.home', compact(
            'title',
            'totalAbsence',
            'totalAttended',
            'attendance',
            'attendanceHistories',
            'checkinTimeSchedule',
            'checkoutTimeSchedule'
        ));
    }
}
