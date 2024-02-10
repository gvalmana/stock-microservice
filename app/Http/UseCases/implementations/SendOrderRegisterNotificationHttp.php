<?php
namespace App\Http\UseCases\implementations;

use App\Adapters\DeliveryConector;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\OrderRegister;
use App\Models\Repositories\IOrderRegisterRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class SendOrderRegisterNotificationHttp implements ISendOrderRegisterNotification
{
    private DeliveryConector $deliveryConector;
    private IOrderRegisterRepository $orderRegisterRepository;
    public function __construct(DeliveryConector $deliveryConector, IOrderRegisterRepository $orderRegisterRepository)
    {
        $this->deliveryConector = $deliveryConector;
        $this->orderRegisterRepository = $orderRegisterRepository;
    }
    public function __invoke($data)
    {
        return $this->notify($data);
    }
    public function notify($data)
    {

        $response = $this->deliveryConector->notifyUpdate($data);
        if ($response->success) {
            $this->orderRegisterRepository->setDeliveredStatus($data['code']);
        }
    }
}
