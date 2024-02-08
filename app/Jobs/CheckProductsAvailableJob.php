<?php

namespace App\Jobs;

use App\Models\OrderRegister;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CheckProductsAvailableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private OrderRegister $orderRegister;
    /**
     * Create a new job instance.
     */
    public function __construct(OrderRegister $orderRegister)
    {
        $this->orderRegister = $orderRegister;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
