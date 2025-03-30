<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePositionRequest;
use App\Http\Requests\UpdatePositionRequest;
use App\Repositories\PositionRepository;
use App\Repositories\WorkingHourRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    protected $positionRepository;
    protected $workingHourRepository;

    public function __construct(PositionRepository $positionRepository, WorkingHourRepository $workingHourRepository)
    {
        $this->positionRepository = $positionRepository;
        $this->workingHourRepository = $workingHourRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $positions = $this->positionRepository->searchWithPagination($keyword, 10);
        } else {
            $positions = $this->positionRepository->getAllWithPagination(10);
        }

        $workingHours = $this->workingHourRepository->getAll();
        $title = 'Jabatan';
        return view('pages.panel.position.index', compact('title', 'positions', 'workingHours'));
    }

    public function show($id)
    {
        $position = $this->positionRepository->getById($id);

        if (!$position) {
            abort(404);
        }

        $title = $position->name;
        return view('pages.panel.position.show', compact('title', 'position'));
    }

    public function store(StorePositionRequest $request)
    {
        $payload = $request->only(['name', 'salary', 'is_active', 'is_enabled_shift', 'working_hour_id']);
        $this->positionRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdatePositionRequest $request, $id)
    {
        $payload = $request->only(['name', 'salary', 'working_hour_id']);
        $this->positionRepository->update($id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->positionRepository->delete($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan berhasil dihapus');
        return to_route('panel.position');
    }

    public function activate($id)
    {
        $this->positionRepository->activate($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan berhasil diaktifkan');
        return to_route('panel.position');
    }

    public function deactivate($id)
    {
        $this->positionRepository->deactivate($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan berhasil dinonaktifkan');
        return to_route('panel.position');
    }

    public function enabledShift($id)
    {
        $this->positionRepository->enabledShift($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan shift berhasil diaktifkan');
        return to_route('panel.position');
    }

    public function disabledShift($id)
    {
        $this->positionRepository->disabledShift($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jabatan shift berhasil diaktifkan');
        return to_route('panel.position');
    }
}
