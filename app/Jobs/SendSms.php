<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Kavenegar\KavenegarApi;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private array $params;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $kavenegar =  new KavenegarApi(config('kavenegar.apikey'));
        if ($this->params['type'] == 'simple') {
            $kavenegar->Send(config('kavenegar.sender'), $this->params['receptor'], $this->params['message']);
        }
        else {
            $kavenegar->VerifyLookup(
                $this->params['receptor'],
                $this->params['tokens'][0],
                $this->params['tokens'][1],
                $this->params['tokens'][2],
                $this->params['template'],
            );
        }
    }
}
