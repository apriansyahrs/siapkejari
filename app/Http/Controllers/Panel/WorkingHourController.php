<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWorkingHourRequest;
use App\Http\Requests\UpdateWorkingHourRequest;
use App\Repositories\WorkingHourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class WorkingHourController extends Controller
{
    protected $workingHourRepository;

    public function __construct(WorkingHourRepository $workingHourRepository)
    {
        $this->workingHourRepository = $workingHourRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $workingHours = $this->workingHourRepository->searchWithPagination($keyword, 10);
        } else {
            $workingHours = $this->workingHourRepository->getAllWithPagination(10);
        }

        $title = 'Jam Kerja';
        return view('pages.panel.working-hour.index', compact('title', 'workingHours'));
    }

    public function show($id)
    {
        $workingHour = $this->workingHourRepository->getById($id);

        if (!$workingHour) {
            abort(404);
        }

        $title = $workingHour->name;
        return view('pages.panel.working-hour.show', compact('title', 'workingHour'));
    }

    public function store(StoreWorkingHourRequest $request)
    {
        $payload = $request->only(['name', 'checkin_time', 'checkout_time']);
        $this->workingHourRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jam kerja berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateWorkingHourRequest $request, $id)
    {
        $payload = $request->only(['name', 'checkin_time', 'checkout_time']);
        $this->workingHourRepository->update($id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jam kerja berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->workingHourRepository->delete($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jam kerja berhasil dihapus');
        return to_route('panel.working-hour');
    }
}
