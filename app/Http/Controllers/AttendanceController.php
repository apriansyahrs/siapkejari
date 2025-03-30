<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckinRequest;
use App\Http\Requests\CheckoutRequest;
use App\Repositories\AttendanceRepository;
use App\Repositories\ShiftScheduleRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    protected $shiftScheduleRepository;

    public function __construct(AttendanceRepository $attendanceRepository, ShiftScheduleRepository $shiftScheduleRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
        $this->shiftScheduleRepository = $shiftScheduleRepository;
    }

    public function index()
    {
        $attendances = $this->attendanceRepository->getByEmployeeIdWithLimit(auth('employee')->user()->id, 10);
        $title = 'Attendance';
        return view('pages.attendance.index', compact('title', 'attendances'));
    }

    public function create()
    {
        $title = 'Checkin';
        $attendance = $this->attendanceRepository->getByEmployeeIdAndCheckinDate(auth('employee')->user()->id, date('Y-m-d'));

        if ($attendance && $attendance->checkout_time) {
            Session::flash('toast-status', 'warning');
            Session::flash('toast-text', 'You already check out');
            return redirect()->back();
        }

        return view('pages.attendance.create', compact('title', 'attendance'));
    }

    public function checkin(CheckinRequest $request)
    {
        $user = auth('employee')->user();
        $checkin = $this->attendanceRepository->getByEmployeeIdAndCheckinDate($user->id, date('Y-m-d'));

        if ($checkin) {
            return response()->json([
                'status' => 'failed',
                'message' => 'kamu sudah melakukan presensi'
            ]);
        }

        if (!$user->is_free_radius) {
            $distance = $this->calculateDistance($request->latitude, $request->longitude);

            if ($distance > 100) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'You\'re outside the radius'
                ]);
            }
        }

        $checkoutDate = date('Y-m-d');

        if ($user->position->is_enabled_shift) {
            $shiftSchedule = $this->shiftScheduleRepository->getByEmployeeIdAndDate($user->id, date('Y-m-d'));
            $checkinTimestamp = strtotime($shiftSchedule->checkin_time);
            $checkoutTimestamp = strtotime($shiftSchedule->checkout_time);
            $differenceHour = ($checkoutTimestamp - $checkinTimestamp) / 3600;

            if ($differenceHour <= 0) {
                $checkoutDate = date('Y-m-d', strtotime('+1day'));
            }
        } else {
            $checkinTimestamp = strtotime($user->position->workingHour->checkin_time);
        }

        $splitPhoto = explode(';base64', $request->photo);
        $photoBase64Decoded = base64_decode($splitPhoto[1]);
        $filename = $user->nik.date('Ymd').time().'.jpeg';
		$time = date('H:i:s');
		$oneMinute = 60 * 1;
		$lateinMinute = intval((strtotime($time) - $checkinTimestamp) / $oneMinute);
        $payload = [
            'employee_id' => $user->id,
            'checkin_date' => date('Y-m-d'),
            'checkin_time' => $time,
            'checkin_photo' => $filename,
            'checkin_latitude' => $request->latitude,
            'checkin_longitude' => $request->longitude,
            'checkout_date' => $checkoutDate,
            'status' => 'Hadir'
        ];

        if ($lateinMinute > 0) {
            $payload['checkin_late'] = $lateinMinute;
        }

        Storage::disk('public')->put('attendances/'.$filename, $photoBase64Decoded);
        $this->attendanceRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-text', 'check in successful');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function checkout(CheckoutRequest $request)
    {
        $user = auth('employee')->user();
        $attendance = $this->attendanceRepository->getByEmployeeIdAndCheckoutDate($user->id, date('Y-m-d'));

        if (!$attendance) {
            return response()->json([
                'status' => 'failed',
                'message' => 'kamu belum melakukan presensi'
            ]);
        }

        if (
            $attendance->checkout_photo
            || $attendance->checkout_latitude
            || $attendance->checkout_longitude
        ) {
            return response()->json([
                'status' => 'failed',
                'message' => 'kamu sudah melakukan presensi'
            ]);
        }

        if (!$user->is_free_radius) {
            $distance = $this->calculateDistance($request->latitude, $request->longitude);

            if ($distance > 100) {
                return response()->json([
                    'status' => 'failed',
                    'message' => 'You\'re outside the radius'
                ]);
            }
        }

        if ($user->position->is_enabled_shift) {
            $shiftSchedule = $this->shiftScheduleRepository->getByEmployeeIdAndDate($user->id, $attendance->checkin_date);
            $checkoutTime = $shiftSchedule->shift->checkout_time;
            $checkoutTimestamp = strtotime($checkoutTime);
        } else {
            $checkoutTime = $user->position->workingHour->checkout_time;
            $checkoutTimestamp = strtotime($checkoutTime);
        }

		$time = date('H:i:s');

        if ($time < $checkoutTime) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Check out failed, you are still working hours'
            ]);
        }

        $splitPhoto = explode(';base64', $request->photo);
        $photoBase64Decoded = base64_decode($splitPhoto[1]);
        $filename = $user->nik.date('Ymd').time().'.jpeg';
		$oneMinute = 60;
		$checkoutEarly = intval(($checkoutTimestamp - strtotime($time)) / $oneMinute);
        $workingHour = intval(Carbon::parse($attendance->checkin_date.' '.$attendance->checkin_time)->diffInMinutes(date('Y-m-d').' '.$time));
        $payload = [
            'checkout_time' => $time,
            'checkout_photo' => $filename,
            'checkout_latitude' => $request->latitude,
            'checkout_longitude' => $request->longitude,
            'working_hour' => $workingHour
        ];

        if ($checkoutEarly > 0) {
            $payload['checkout_early'] = $checkoutEarly;
        }

        Storage::disk('public')->put('attendances/'.$filename, $photoBase64Decoded);
        $this->attendanceRepository->checkoutById($attendance->id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-text', 'check out successful');
        return response()->json([
            'status' => 'success'
        ]);
    }

    private function calculateDistance($latitude, $longitude)
    {
        $earthRadius = 6371000;

        $lat1 = deg2rad($latitude);
        $lon1 = deg2rad($longitude);
        $lat2 = deg2rad(env('PLACE_LATITUDE'));
        $lon2 = deg2rad(env('PLACE_LONGITUDE'));

        $latDelta = $lat2 - $lat1;
        $lonDelta = $lon2 - $lon1;

        $a = sin($latDelta / 2) * sin($latDelta / 2) + cos($lat1) * cos($lat2) * sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
