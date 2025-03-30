<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHealthInsuranceRequest;
use App\Http\Requests\UpdateHealthInsuranceRequest;
use App\Repositories\HealthInsuranceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HealthInsuranceController extends Controller
{
    protected $healthInsuranceRepository;

    public function __construct(HealthInsuranceRepository $healthInsuranceRepository)
    {
        $this->healthInsuranceRepository = $healthInsuranceRepository;
    }

    public function index()
    {
        $keyword = request()->keyword;

        if ($keyword) {
            $healthInsurances = $this->healthInsuranceRepository->searchWithPagination($keyword, 10);
        } else {
            $healthInsurances = $this->healthInsuranceRepository->getAllWithPagination(10);
        }

        $title = 'Jaminan Kesehatan';
        return view('pages.panel.health-insurance.index', compact('title', 'healthInsurances'));
    }

    public function show($id)
    {
        $healthInsurance = $this->healthInsuranceRepository->getById($id);

        if (!$healthInsurance) {
            abort(404);
        }

        $title = 'Jaminan Kesehatan';
        return view('pages.panel.health-insurance.show', compact('title', 'healthInsurance'));
    }

    public function store(StoreHealthInsuranceRequest $request)
    {
        $payload = $request->only(['name', 'class', 'contribution']);
        $this->healthInsuranceRepository->create($payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jaminan kesehatan berhasil dibuat');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function update(UpdateHealthInsuranceRequest $request, $id)
    {
        $payload = $request->only(['name', 'class', 'contribution']);
        $this->healthInsuranceRepository->update($id, $payload);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jaminan kesehatan berhasil diperbarui');
        return response()->json([
            'status' => 'success'
        ]);
    }

    public function destroy($id)
    {
        $this->healthInsuranceRepository->delete($id);
        Session::flash('toast-status', 'success');
        Session::flash('toast-title', 'Sukses');
        Session::flash('toast-text', 'Jaminan kesehatan berhasil dihapus');
        return to_route('panel.health-insurance');
    }
}
