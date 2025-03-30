<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHolidayRequest;
use App\Http\Requests\UpdateHolidayRequest;
use App\Repositories\HolidayRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HolidayController extends Controller
{
    protected $holidayRepository;

    public function __construct(HolidayRepository  $holidayRepository)
    {
        $this->holidayRepository = $holidayRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $holidays = $this->holidayRepository->searchWithPagination($keyword, 10);
        } else {
            $holidays = $this->holidayRepository->getAllWithPagination(10);
        }

        $title = 'Hari Libur';
        return view('pages.panel.holiday.index', compact('title', 'holidays'));
    }

    public function show($id)
    {
        $holiday = $this->holidayRepository->getById($id);

        if (!$holiday) {
            abort(404);
        }

        $title = $holiday->title;
        return view('pages.panel.holiday.show', compact('title', 'holiday'));
    }

    public function store(StoreHolidayRequest $request)
    {
        $payload = $request->only(['title', 'date']);

        $this->holidayRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Hari libur berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateHolidayRequest $request, $id)
    {
        $payload = $request->only(['title', 'date']);

        $this->holidayRepository->update($id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Hari libur berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->holidayRepository->delete($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Hari libur berhasil dihapus');
        return to_route('panel.holiday');
    }
}
