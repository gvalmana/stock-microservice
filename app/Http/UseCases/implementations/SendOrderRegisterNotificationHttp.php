<?php
namespace App\Http\UseCases\implementations;

use App\Adapters\DeliveryConector;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\OrderRegister;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendOrderRegisterNotificationHttp implements ISendOrderRegisterNotification
{
    private DeliveryConector $deliveryConector;
    public function __construct(DeliveryConector $deliveryConector)
    {
        $this->deliveryConector = $deliveryConector;
    }
    public function __invoke($data)
    {
        return $this->notify($data);
    }
    public function notify($data)
    {

        $response = $this->deliveryConector->notifyUpdate($data);
        if ($response->success) {
            $order = OrderRegister::where('code', $data['code'])->first();
            $order->delivered = true;
            $order->delivery_at = Carbon::now();
            $order->save();
        }
    }
}
