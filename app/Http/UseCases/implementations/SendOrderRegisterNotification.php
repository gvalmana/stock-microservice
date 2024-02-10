<?php
namespace App\Http\UseCases\implementations;

use App\Adapters\DeliveryConector;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\OrderRegister;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendOrderRegisterNotification implements ISendOrderRegisterNotification
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

        // 'event'=> ['required', 'string',Rule::in(['update_cooking_status','failed_getting_stock'])],
        // 'data'=>  ['required', 'array'],
        // 'data.order_code'=> ['required', 'string'],
        $order_code = $data['code'];
        $payload = [
            'event' => 'update_cooking_status',
            'data' => compact('order_code'),
        ];
        $response = $this->deliveryConector->notifyUpdate($payload);
        if ($response->success) {
            $order = OrderRegister::where('code', $data['code'])->first();
            $order->delivered = true;
            $order->delivery_at = Carbon::now();
            $order->save();
        }
    }
}
