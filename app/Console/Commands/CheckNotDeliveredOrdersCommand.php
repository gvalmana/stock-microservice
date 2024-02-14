<?php

namespace App\Console\Commands;

use App\Events\OrderRegisterFulled;
use App\Http\UseCases\IBuyProduct;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\Repositories\IOrderRegisterRepository;
use App\Traits\LogAndOutputTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CheckNotDeliveredOrdersCommand extends Command
{
    use LogAndOutputTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-not-delivered-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check not delivered orders';

    /**
     * Execute the console command.
     */
    public function handle(IOrderRegisterRepository $repository)
    {
        $this->info('Checking not delivered orders...');
        $orders = $repository->getNotDeliveredOrders();
        $this->checkOrdesStatus($orders);
        $this->info('Done!');
    }

    private function checkOrdesStatus($orders)
    {
        foreach ($orders as $order) {
            $this->logAndOutput("Order {$order->code} not delivered");
            if ($order->fulled) {
                $this->logAndOutput("Order {$order->code} already fulled");
                OrderRegisterFulled::dispatch($order);
            }
        }
    }
}
