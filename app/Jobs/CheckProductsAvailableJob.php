<?php

namespace App\Jobs;

use App\Http\UseCases\IBuyProduct;
use App\Models\OrderRegister;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
    public function handle(IBuyProduct $service): void
    {
        if (!$this->orderRegister->filled) {
            $ingredients = $this->orderRegister->ingredients;
            foreach ($ingredients as $item) {
                if ($item->product->available_quantity >= $item->quantity) {
                    $item->fulled = true;
                    $item->product->available_quantity -= $item->quantity;
                    $item->product->save();
                    $item->save();
                } else {
                    $service->buyProduct($item);
                }
            }
        }
    }
}
