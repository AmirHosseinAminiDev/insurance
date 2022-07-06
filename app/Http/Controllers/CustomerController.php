<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentSearchRequest;
use App\Models\Customer;
use App\Http\Requests\CustomerRequest;
use App\Models\Sale;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request): View|Factory|Application
    {
        return view('admin.pages.customers.index', [
            'customersList' => Customer::filter($request->all())->latest()->paginate(config('settings.pagination')),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function store(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->create([
            'first_name' => $request->getFirstName(),
            'last_name' => $request->getLastName(),
            'national_code' => $request->getNationalCode(),
            'mobile' => $request->getMobile()
        ]);
        alert()->success(__('messages.success.customers.store'));
        return redirect()->route('customers.list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customer $customer
     * @return Application|Factory|View
     */
    public function edit(Customer $customer): Application|Factory|View
    {
        return view('admin.pages.customers.edit', [
            'customer' => $customer,
            'customersList' => Customer::latest()->paginate(config('settings.pagination')),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        $customer->update([
            'first_name' => $request->getFirstName(),
            'last_name' => $request->getLastName(),
            'mobile' => $request->getMobile(),
            'national_code' => $request->getNationalCode(),
        ]);
        alert()->success(__('messages.success.customers.update'));
        return redirect()->route('customers.list');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        $customer->delete();
        alert()->success(__('messages.success.customers.delete'));
        return redirect()->route('customers.list');
    }

    public function showPayments(Sale $sale, PaymentSearchRequest $request): Factory|View|Application
    {
        $payments = $sale->payments();

        if ($request->has('sortFilter')) {
            if ($request->get('sortFilter') != 'all') {
                $payments->where('status', $request->get('sortFilter'));
            }
        }

        if ($request->get('startDate')) {
            $startDate = Jalalian::fromFormat('Y/m/d', $request->get('startDate'))->toCarbon()->format('Y/m/d');
            $payments->whereBetween('created_at', [$startDate, now()]);
        }

        if ($request->get('endDate')) {
            $endDate = Jalalian::fromFormat('Y/m/d', $request->get('endDate'))->toCarbon()->format('Y/m/d');
//            $payments->whereBetween('created_at', [, $endDate]);
        }

        if ($request->get('startDate') && $request->get('endDate')) {
            $startDate = Jalalian::fromFormat('Y/m/d', $request->get('startDate'))->toCarbon()->format('Y/m/d');
            $endDate = Jalalian::fromFormat('Y/m/d', $request->get('endDate'))->toCarbon()->format('Y/m/d');
            $payments->whereBetween('created_at', [$startDate, $endDate]);
        }

        return view('admin.pages.customers.show-payments', [
            'sale' => $sale,
            'payments' => $payments->paginate(config('settings.pagination')),
        ]);
    }
}
