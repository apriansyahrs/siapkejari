<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportAttendanceRequest;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;
use App\Repositories\AttendanceRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\HolidayRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    protected $attendanceRepository;
    protected $employeeRepository;
    protected $holidayRepository;

    public function __construct(
        AttendanceRepository $attendanceRepository,
        EmployeeRepository $employeeRepository,
        HolidayRepository $holidayRepository
    ) {
        $this->attendanceRepository = $attendanceRepository;
        $this->employeeRepository = $employeeRepository;
        $this->holidayRepository = $holidayRepository;
    }

    public function index()
    {
        $date = request()->date ? Carbon::parse(request()->date)->format('Y-m-d') : date('Y-m-d');
        $attendances = $this->attendanceRepository->getByCheckinDateWithPagination($date, 10);
        $employees = $this->employeeRepository->getActive();
        $title = 'Presensi';
        return view('pages.panel.attendance.index', compact('title', 'attendances', 'employees', 'date'));
    }

    public function show($id)
    {
        $attendance = $this->attendanceRepository->getById($id);

        if (!$attendance) {
            abort(404);
        }

        $title = 'Presensi';
        return view('pages.panel.attendance.show', compact('title', 'attendance'));
    }

    public function store(StoreAttendanceRequest $request)
    {
        $payload = $request->only(['employee_id', 'status', 'note', 'checkin_date', 'checkin_time', 'checkout_time']);

        // Use the provided checkin_date or default to today
        $payload['checkin_date'] = $payload['checkin_date'] ?? date('Y-m-d');

        // Use the provided checkin_time or default to 00:00:00
        $payload['checkin_time'] = $payload['checkin_time'] ?? '00:00:00';

        // Set checkout_date to the same as checkin_date
        $payload['checkout_date'] = $payload['checkin_date'];

        // Use the provided checkout_time or default to 00:00:00
        $payload['checkout_time'] = $payload['checkout_time'] ?? '00:00:00';

        $this->attendanceRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Presensi berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function report(ReportAttendanceRequest $request)
    {
        $employeeId = $request->employee_id;
        $period = $request->period;

        if ($employeeId) {
            $document = $this->singleReport($employeeId, $period);
        } else {
            $document = $this->multipleReport($period);
        }

        return response()->stream(function () use ($document) {
            echo $document['stream'];
        }, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $document['filename'] . '"',
        ]);
    }

    private function singleReport($employeeId, $period)
    {
        $periodSplit = explode('-', $period);
        $month = $periodSplit[0];
        $year = $periodSplit[1];
        $endOfMonth = Carbon::parse('01-' . $period)->endOfMonth()->day;
        $attendances = $this->attendanceRepository->getByEmployeeIdAndCheckinPeriod($employeeId, $year, $month);
        $holidays = $this->holidayRepository->getByPeriod($year, $month);
        $holidaysArray = [];
        $attendancesArray = [];

        foreach ($attendances as $item) {
            $attendance = (object) [
                'checkin_date' => $item->checkin_date,
                'checkin_time' => $item->checkin_time,
                'checkout_time' => $item->checkout_time,
                'working_hour' => $item->working_hour,
                'status' => $item->status,
                'note' => $item->note
            ];

            array_push($attendancesArray, $attendance);
        }

        foreach ($holidays as $item) {
            $holiday = (object) [
                'checkin_date' => $item->date,
                'checkin_time' => null,
                'checkout_time' => null,
                'working_hour' => null,
                'status' => 'Libur',
                'note' => $item->title
            ];

            array_push($holidaysArray, $item->date);
            array_push($attendancesArray, $holiday);
        }

        for ($i = 1; $i <= $endOfMonth; $i++) {
            $dateString = strval($i);
            $day = Carbon::parse($dateString . '-' . $period)->format('D');

            if (in_array($day, ['Sat', 'Sun'])) {
                $date = Carbon::parse($dateString . '-' . $period)->format('Y-m-d');
                if (!in_array($date, $holidaysArray)) {
                    $weekday = (object) [
                        'checkin_date' => $date,
                        'checkin_time' => null,
                        'checkout_time' => null,
                        'working_hour' => null,
                        'status' => 'Libur',
                        'note' => null
                    ];
                    array_push($attendancesArray, $weekday);
                }
            }
        }

        usort($attendancesArray, function ($a, $b) {
            return $a > $b;
        });

        $totalAbsence = $this->attendanceRepository->countAbsenceByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalAttended = $this->attendanceRepository->countAttendedByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalCheckinLate = $this->attendanceRepository->countCheckinLateByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalCheckoutEarly = $this->attendanceRepository->countCheckoutEarlyByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalSick = $this->attendanceRepository->countSickByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalPermission = $this->attendanceRepository->countPermissionByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalWithoutExplanation = $this->attendanceRepository->countWithoutExplanationByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalWorkingHour = $this->attendanceRepository->sumWorkingHourByEmployeeIdAndPeriod($employeeId, $year, $month);
        $totalNoAttendanceCheckout = $this->attendanceRepository->countNoAttendanceCheckoutByEmployeeIdAndPeriod($employeeId, $year, $month);
        $hour = floor($totalWorkingHour / 60);
        $remainingMinutes = $totalWorkingHour % 60;
        $timeFormatted = "{$hour} Jam {$remainingMinutes} Menit";
        $employee = $this->employeeRepository->getById($employeeId);
        $filename = 'Rekap Presensi - ' . $employee->name . '_' . Carbon::parse('01-' . $period)->translatedFormat('F Y') . '.pdf';
        $data = [
            'attendances' => $attendancesArray,
            'employee' => $employee,
            'period' => $period,
            'totalAbsence' => $totalAbsence,
            'totalAttended' => $totalAttended,
            'totalCheckinLate' => $totalCheckinLate,
            'totalCheckoutEarly' => $totalCheckoutEarly,
            'totalSick' => $totalSick,
            'totalPermission' => $totalPermission,
            'totalWithoutExplanation' => $totalWithoutExplanation,
            'totalWorkingHour' => $timeFormatted,
            'totalNoAttendanceCheckout' => $totalNoAttendanceCheckout
        ];
        $pdf = Pdf::loadView('printed.attendance.single', $data);
        $pdf->setPaper('A4');
        return [
            'stream' => $pdf->stream($filename),
            'filename' => $filename
        ];
    }

    private function multipleReport($period)
    {
        $periodSplit = explode('-', $period);
        $month = $periodSplit[0];
        $year = $periodSplit[1];
        $attendances = $this->attendanceRepository->getAttendanceRecap($year, $month);
        $filename = 'Rekap Presensi - ' . Carbon::parse('01-' . $period)->translatedFormat('F Y') . '.pdf';
        $pdf = Pdf::loadView('printed.attendance.multiple', ['attendances' => $attendances, 'period' => $period]);
        $pdf->setPaper('A4');
        return [
            'stream' => $pdf->stream($filename),
            'filename' => $filename
        ];
    }

    public function update($id, UpdateAttendanceRequest $request)
    {
        // dd($request);
        $attendance = $this->attendanceRepository->getById($id);

        if (!$attendance) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Presensi tidak ditemukan'
            ], 404);
        }

        $payload = $request->only(['checkin_time', 'checkout_time']);

        // Calculate checkin_late based on optimal work start time (08:00)
        if (isset($payload['checkin_time'])) {
            $optimalStartTime = '08:00';
            $checkinTime = $payload['checkin_time'];
            
            // If checkin time is 08:00 or earlier, set checkin_late to null
            if (strtotime($checkinTime) <= strtotime($optimalStartTime)) {
                $payload['checkin_late'] = null;
            } else {
                // Calculate late minutes
                $lateMinutes = (strtotime($checkinTime) - strtotime($optimalStartTime)) / 60;
                $payload['checkin_late'] = $lateMinutes;
            }
        }

        // Calculate checkout_early based on optimal work end time (16:00)
        if (isset($payload['checkout_time'])) {
            $optimalEndTime = '16:00';
            $checkoutTime = $payload['checkout_time'];
            
            // If checkout time is 16:00 or later, set checkout_early to null
            if (strtotime($checkoutTime) >= strtotime($optimalEndTime)) {
                $payload['checkout_early'] = null;
            } else {
                // Calculate early minutes
                $earlyMinutes = (strtotime($optimalEndTime) - strtotime($checkoutTime)) / 60;
                $payload['checkout_early'] = $earlyMinutes;
            }
        }

        // Update the attendance record
        $attendance->update($payload);

        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Presensi berhasil diperbarui');

        return response()->json([
            'status' => 'success'
        ]);
    }
}
