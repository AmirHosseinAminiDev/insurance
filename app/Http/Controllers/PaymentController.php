<?php

namespace App\Http\Controllers;

use App\Constants\PaymentStatus;
use App\Constants\PaymentType;
use App\Http\Requests\PaymentSearchRequest;
use App\Models\Customer;
use App\Models\Payment;
use App\Http\Requests\PaymentRequest;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Morilog\Jalali\Jalalian;

class PaymentController extends Controller
{
    /**
     * @return Factory|View|Application
     */
    public function index(): Factory|View|Application
    {
        $payments = Payment::filter(request()->all())->latest();
        return view('admin.pages.payments.index', [
            'payments' => $payments->paginate(config('settings.pagination')),
            'customers' => Customer::all(),
        ]);
    }


    /**
     * @param Payment $payment
     * @return Factory|View|Application
     */
    public function show(Payment $payment): Factory|View|Application
    {
        return view('admin.pages.payments.show', [
            'payment' => $payment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Payment $payment
     * @return Application|Factory|View
     */
    public function edit(Payment $payment): View|Factory|Application
    {
        return view('admin.pages.customers.pay-payment', [
            'payment' => $payment
        ]);
    }

    /**
     * @param Sale $sale
     * @return Factory|View|Application
     */
    public function bulkEdit(Sale $sale): Factory|View|Application
    {
        return view('admin.pages.customers.bulk-payments', [
            'sale' => $sale,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PaymentRequest $request
     * @param Payment $payment
     * @return RedirectResponse
     */
    public function update(PaymentRequest $request, Payment $payment): RedirectResponse
    {
        $fields = [
            'payment_date' => Carbon::now(),
            'type' => $request->type,
        ];
        if ($request->hasFile('attachment')) {
            $this->uploadAttachment($request->file('attachment'), $payment);
        }
        if ($request->amount == $payment->amount) {
            $payment->update(array_merge($fields, [
                'status' => PaymentStatus::PAID,
            ]));
            alert()->success(__('messages.success.payment.update'));
            return redirect()->route('customers.list');
        }
        if ($request->amount > $payment->amount) {
            alert()->error(__('messages.error.payment.max-pay'));
            return redirect()->back();
        }
        $payment->update(array_merge($fields, [
            'status' => PaymentStatus::PENDING,
        ]));
        alert()->success(__('messages.success.payment.update'));
        return redirect()->route('customers.list');
    }

    /**
     * @param Payment $payment
     * @return Factory|View|Application
     */
    public function showPaymentStatus(Payment $payment): Factory|View|Application
    {
        return view('admin.pages.customers.update-status', [
            'payment' => $payment
        ]);
    }

    /**
     * @param Payment $payment
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateStatus(Payment $payment, Request $request): RedirectResponse
    {
        $payment->update([
            'status' => $request->status,
            'type' => $request->type,
            'payment_date' => Carbon::now(),
        ]);
        alert()->success(__('messages.success.payment.update'));
        return redirect()->route('payments.index');
    }


    /**
     * @param Sale $sale
     * @param Request $request
     * @return RedirectResponse
     */
    public function bulkUpdate(Sale $sale, Request $request): RedirectResponse
    {
        $payments = Payment::where('sale_id', $sale->id)->where('status', PaymentStatus::UNPAID)->get();
        if ($request->amount != $payments->sum('amount')) {
            alert()->error(__('messages.error.bulk-payment.amount.not-matched'));
            return redirect()->back();
        }
        foreach ($payments as $payment) {
            $payment->update([
                'payment_date' => Carbon::now(),
                'amount' => $request->amount,
                'type' => PaymentType::ONLINE,
                'status' => PaymentStatus::PAID,
            ]);
        }
        alert()->success(__('messages.success.payment.update'));
        return redirect()->route('customers.list');
    }

    /**
     * @param $image
     * @param $payment
     * @return void
     */
    protected function uploadAttachment($image, $payment)
    {
        $name = $image->getClientOriginalName();
        $payment->update([
            'attachment' => $name
        ]);
        $path = Storage::putFile('attachments', $image);
    }

    /**
     * @param Payment $payment
     * @return Factory|View|Application
     */
    public function showInvoice(Payment $payment): Factory|View|Application
    {
        return view('admin.pages.payments.invoice', ['payment' => $payment]);
    }
}
