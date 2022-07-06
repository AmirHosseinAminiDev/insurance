<?php

namespace App\Http\Controllers;

use App\Constants\SaleType;
use App\Http\Requests\SaleRequest;
use App\Http\Requests\UpdateDateReuest;
use App\Models\Customer;
use App\Models\InsuranceType;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class SaleController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        return view('admin.pages.sales.index', [
            'customers' => Customer::all(),
            'insurances' => InsuranceType::all(),
            'sales' => Sale::filter(request()->all())->with(['customer', 'insuranceType'])->paginate(config('settings.pagination')),
        ]);
    }

    /**
     * @param SaleRequest $request
     *
     * @return RedirectResponse
     */
    public function store(SaleRequest $request): RedirectResponse
    {

        $sale = Sale::create([
            'customer_id' => $request->customer_id,
            'agent_id' => auth()->user()->id,
            'insurance_type_id' => $request->insurance_type_id,
            'price' => $request->price,
            'pay_type' => $request->pay_type,
        ]);
        if ($request->get('pay_type') == SaleType::INSTALLMENT) {
            $this->createUserPayments($request->count, $sale->id);
            return redirect()->route('sales.show.date', $sale);
        }
        alert()->success(__('messages.success.sale.store'));
        return redirect()->route('sales.index');

    }

    /**
     * @param Sale $sale
     *
     * @return Factory|View|Application
     */
    public function edit(Sale $sale): Factory|View|Application
    {
        return view('admin.pages.sales.edit', [
            'sale' => $sale,
            'customers' => Customer::all(),
            'insurances' => InsuranceType::all(),
        ]);
    }

    /**
     * @param Sale        $sale
     * @param SaleRequest $request
     *
     * @return RedirectResponse
     */
    public function update(Sale $sale, SaleRequest $request): RedirectResponse
    {
        $sale->update([
            'customer_id' => $request->customer_id,
            'agent_id' => auth()->user()->id,
            'insurance_type_id' => $request->insurance_type_id,
            'price' => $request->price,
            'pay_type' => $request->pay_type,
        ]);
        return redirect()->route('sales.index');

    }

    /**
     * @param $count
     * @param $sale
     *
     * @return array
     */
    private function createUserPayments($count, $sale): array
    {
        $attribute = [];
        for ($i = 0; $i < $count; $i++){
            $attribute[] = Payment::create([
                'sale_id' => $sale,
                'status' => 'unpaid'
            ]);
        }
        return $attribute;
    }

    /**
     * @param Sale $sale
     *
     * @return Factory|View|Application
     */
    public function showDate(Sale $sale): Factory|View|Application
    {
        return view('admin.pages.sales.update-date', [
            'sale' => $sale
        ]);
    }

    /**
     * @param Sale             $sale
     * @param UpdateDateReuest $request
     *
     * @return RedirectResponse
     */
    public function updateDates(Sale $sale, UpdateDateReuest $request): RedirectResponse
    {
        if ($request->collect('amount')->sum() != $sale->price) {
            alert()->error(__('messages.error.sale.amount-price'));
            return redirect()->back()->withInput();
        }
        $item = 0;
        foreach ($sale->payments as $payment){
            $payment->update([
                'due_date' => Jalalian::fromFormat('Y/m/d', $request->get('date')[$item])->toCarbon(),
                'amount' => $request->get('amount')[$item],
            ]);
            $item++;
        }
        alert()->success(__('messages.success.sale.store'));
        return redirect()->route('sales.index');
    }

    /**
     * @param Sale $sale
     *
     * @return RedirectResponse
     */
    public function destroy(Sale $sale): RedirectResponse
    {
        $sale->delete();
        alert()->success(__('messages.success.sale.delete'));
        return redirect()->route('sales.index');
    }

    /**
     * @param Customer $customer
     *
     * @return Factory|View|Application
     */
    public function showCustomerInsurances(Customer $customer): Factory|View|Application
    {
        return view('admin.pages.sales.show-customer-insurances-list', [
            'customer' => $customer
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'startDate' => 'nullable|date_format:Y/m/d',
            'endDate' => 'nullable|date_format:Y/m/d'
        ]);
        $sales = Sale::query()->latest();
        if ($request->get('startDate')) {
            $startDate = Jalalian::fromFormat('Y/m/d', $request->get('startDate'))->toCarbon()->format('Y/m/d');
            $sales->whereBetween('created_at', [$startDate, now()]);
        }
        if ($request->get('endDate')) {
            $endDate = Jalalian::fromFormat('Y/m/d', $request->get('endDate'))->toCarbon()->format('Y/m/d');
//            $payments->whereBetween('created_at', [, $endDate]);
        }
        if ($request->get('startDate') && $request->get('endDate')) {
            $startDate = Jalalian::fromFormat('Y/m/d', $request->get('startDate'))->toCarbon()->format('Y/m/d');
            $endDate = Jalalian::fromFormat('Y/m/d', $request->get('endDate'))->toCarbon()->format('Y/m/d');
            $sales->whereBetween('created_at', [$startDate, $endDate]);
        }
        return view('admin.pages.sales.index', [
            'sales' => $sales->paginate(config('settings.pagination')),
            'customers' => Customer::all(),
            'insurances' => InsuranceType::all(),
        ]);
    }
}
