<?php

namespace App\Console;

use App\Jobs\SendSms;
use App\Models\Payment;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Kavenegar;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $expiredPayments = Payment::where('status', 'unpaid')->where('due_date', '=<', Carbon::now()->subDays(3)->format('Y/m/d'))->get();
        $threeDaysUnpaidPayments = Payment::where('status', '!=', 'paid')->where('due_date', '=', Carbon::now()->addDays(3)->format('Y/m/d'))->get();
        $tenDaysRemaining = Payment::where('status', '!=', 'paid')->where('due_date', '=', Carbon::now()->addDays(10)->format('Y/m/d'))->get();
        $todayReminder = Payment::where('status', '!=', 'paid')->where('due_date', today())->get();

        $schedule->call(function () use ($threeDaysUnpaidPayments, $expiredPayments, $tenDaysRemaining, $todayReminder) {
            foreach ($todayReminder as $payment) {
                SendSms::dispatch([
                    'receptor' => $payment->sale->customer->mobile,
                    'tokens' => [
                        str_replace(" ", "_", $payment->sale->insuranceType->name),
                        24,
                        $payment->unique_code,
                    ],
                    'type' => 'special',
                    'template' => 'today-reminder',
                ]);
            }

            foreach ($tenDaysRemaining as $payment) {
                SendSms::dispatch([
                    'receptor' => $payment->sale->customer->mobile,
                    'tokens' => [
                        str_replace(" ", "_", $payment->sale->insuranceType->name),
                        '10_روز_دیگر',
                        $payment->unique_code,
                    ],
                    'type' => 'special',
                    'template' => 'payment-duedate',
                ]);
            }

            foreach ($threeDaysUnpaidPayments as $payment) {
                SendSms::dispatch([
                    'receptor' => $payment->sale->customer->mobile,
                    'tokens' => [
                        str_replace(" ", "_", $payment->sale->insuranceType->name),
                        '3_روز_دیگر',
                        $payment->unique_code,
                    ],
                    'type' => 'special',
                    'template' => 'payment-duedate',
                ]);
            }

            foreach ($expiredPayments as $payment) {
                SendSms::dispatch([
                    'receptor' => $payment->sale->customer->mobile,
                    'tokens' => [
                        str_replace(" ", "_", $payment->sale->insuranceType->name),
                        3,
                        $payment->unique_code,
                    ],
                    'type' => 'special',
                    'template' => 'payment-expired',
                ]);
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
