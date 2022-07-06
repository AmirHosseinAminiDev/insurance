<?php

namespace App\Http\Controllers;

use App\Constants\GatewayStatus;
use App\Constants\PaymentStatus;
use App\Constants\PaymentType;
use App\Jobs\SendSms;
use App\Models\Gateway;
use App\Models\Payment;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request): mixed
    {
        $payment = Payment::find($request->payment);
        return gatewayService()->create([
            'amount' => $payment->amount,
            'payment_id' => $payment->id,
        ]);
    }

    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function verify(Request $request): Factory|View|Application
    {
        $gateway = Gateway::where('transaction_id', $request->get('Authority'))->firstOrFail();
        if ( $gateway->status == GatewayStatus::INIT ) {
            $response = gatewayService()->verify($gateway);
            if ( $response->status == GatewayStatus::SUCCESS ) {
                $gateway->payment->update([
                    'status' => PaymentStatus::PAID,
                    'payment_date' => Carbon::now(),
                    'type' => PaymentType::ONLINE,
                ]);
                SendSms::dispatch([
                    'receptor' => $gateway->payment->sale->customer->mobile,
                    'tokens' => [
                        number_format($gateway->amount),
                        number_format($gateway->payment->where('status', PaymentStatus::UNPAID)->sum('amount')),
                        null,
                    ],
                    'template' => 'payment-success',
                    'type' => 'special',
                ]);
            } else {
                SendSms::dispatch([
                    'type' => 'simple',
                    'receptor' => $gateway->payment->sale->customer->mobile,
                    'message' => __('messages.error.sms.init-paid')
                ]);
                $gateway->payment->update([
                    'status' => PaymentStatus::UNPAID,
                    'type' => PaymentType::ONLINE,
                ]);
            }
        }
        return view('admin.pages.payments.payment-status', compact('gateway'));
    }
}
