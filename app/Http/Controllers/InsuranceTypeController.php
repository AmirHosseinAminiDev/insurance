<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsuranceTypeRequest;
use App\Http\Requests\UpdateInsuranceTypeRequest;
use App\Models\InsuranceType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InsuranceTypeController extends Controller
{

    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('admin.pages.insurances.index', [
            'insurancesList' => InsuranceType::latest()->paginate(config('settings.pagination')),
        ]);
    }

    /**
     * @param InsuranceTypeRequest $request
     * @param InsuranceType $insuranceType
     * @return RedirectResponse
     */
    public function store(InsuranceTypeRequest $request, InsuranceType $insuranceType): RedirectResponse
    {
        $insuranceType->create([
            'name' => $request->getName(),
            'insurance_code' => $request->getInsuranceCode(),
        ]);
        alert()->success(__('messages.success.insurance.store'));
        return redirect()->back();
    }

    /**
     * @param InsuranceType $insuranceType
     * @return Factory|View|Application
     */
    public function edit(InsuranceType $insuranceType): Factory|View|Application
    {
        return view('admin.pages.insurances.edit', [
            'insurance' => $insuranceType,
            'insurancesList' => InsuranceType::latest()->paginate(config('settings.pagination')),
        ]);
    }

    /**
     * @param InsuranceTypeRequest $request
     * @param InsuranceType $insuranceType
     * @return RedirectResponse
     */
    public function update(InsuranceTypeRequest $request, InsuranceType $insuranceType): RedirectResponse
    {
        $insuranceType->update([
            'name' => $request->getName(),
            'insurance_code' => $request->getInsuranceCode(),
        ]);
        alert()->success(__('messages.success.insurance.update'));
        return redirect()->route('insurances.list');
    }

    /**
     * @param InsuranceType $insuranceType
     * @return RedirectResponse
     */
    public function destroy(InsuranceType $insuranceType): RedirectResponse
    {
        $insuranceType->delete();
        alert()->success(__('messages.success.insurance.delete'));
        return redirect()->route('insurances.list');
    }
}
