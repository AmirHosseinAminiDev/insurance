<?php

namespace App\Services;

use App\Constants\GatewayStatus;
use App\Models\Gateway;
use App\Models\Plan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;

/**
 * Class GatewayService
 *
 * @package App\Services
 */
class GatewayService
{
    /**
     * @param $param
     * @param $callback
     *
     * @return mixed
     * @throws Exception
     */
    public function create($param)
    {
        $invoice = $this->createInvoice($param);
        return Payment::callbackUrl(route('purchase.verify'))->purchase(
            $invoice,
            function ($driver, $transactionId) use ($invoice) {
                $this->makePaymentInit([
                    'transaction_id' => $transactionId,
                    'amount' => $invoice->getAmount(),
                    'payment_id' => $invoice->getDetail('payment_id')
                ]);
            }
        )->pay()
            ->render();

    }


    /**
     * @param \App\Models\Gateway      $gateway
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Models\Gateway
     */
    public function verify(Gateway $gateway): Gateway
    {

        try {
            $receipt = Payment::amount((int)$gateway->amount)
                ->transactionId($gateway->transaction_id)
                ->verify();
            $this->makePaymentSuccess($gateway, [
                'reference_id' => $receipt->getReferenceId(),
                'driver' => $receipt->getDriver(),
                'payment_id' => $gateway->payment_id
            ]);
        } catch (InvalidPaymentException $exception) {
            $this->makePaymentFailed($gateway, $exception->getMessage());
        } finally {
            return $gateway->refresh();
        }

    }


    /**
     * @param                          $params
     *
     * @return void
     */
    private function makePaymentInit($params): void
    {
        $gateway = new Gateway();
        $gateway->payment_id = $params['payment_id'];
        $gateway->transaction_id = $params['transaction_id'];
        $gateway->amount = $params['amount'];
        $gateway->save();
    }

    /**
     * @param \App\Models\Gateway $gateway
     * @param                     $params
     */
    public function makePaymentSuccess(Gateway $gateway, $params)
    {
        $gateway->update([
            'status' => GatewayStatus::SUCCESS,
            'reference_id' => $params['reference_id'],
            'payment_id' => $params['payment_id'],
            'via' => $params['driver']
        ]);
    }

    /**
     * @param \App\Models\Gateway $gateway
     * @param                     $description
     */
    public function makePaymentFailed(Gateway $gateway, $description)
    {
         $gateway->update([
            'status' => GatewayStatus::FAILED,
            'description' => $description,
        ]);
    }

    /**
     * @throws Exception
     */
    public function createInvoice($param): Invoice
    {
        $invoice = new Invoice();
        $invoice->amount((int)$param['amount']);
        $invoice->detail('payment_id', $param['payment_id']);
        return $invoice;
    }
}
