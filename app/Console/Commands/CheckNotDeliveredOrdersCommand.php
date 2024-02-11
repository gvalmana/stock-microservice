<?php

namespace App\Console\Commands;

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
    protected $signature = 'app:check-not-delivered-orders-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check not delivered orders';

    /**
     * Execute the console command.
     */
    public function handle(IOrderRegisterRepository $repository, ISendOrderRegisterNotification $notifier)
    {
        $this->info('Checking not delivered orders...');
        $orders = $repository->getNotDeliveredOrders();
        foreach ($orders as $order) {
            if ($order->fulled) {
                $data = ['code' => $order->code];
                $notifier($data);
            }
        }
        $this->info('Done!');
    }
}
