<?php

namespace App\Adapters\implementations;

use App\Adapters\BaseAdapter;
use App\Adapters\DeliveryConector;
use Illuminate\Support\Facades\Log;

final class DeliveryConectorImpl extends BaseAdapter implements DeliveryConector
{
    private $url;
    public function __construct()
    {
        parent::__construct();
        $this->url = config("globals.delivery_microservice.url").config("globals.delivery_microservice.webhook_order_path");
    }
    public function notifyUpdate($data)
    {
        $order_code = $data['code'];
        $payload = [
            'event' => 'update_cooking_status',
            'data' => compact('order_code'),
        ];
        Log::debug($this->url);
        Log::debug('Starting Order Register Fulled Notification: '. json_encode($data) . ' - '.get_called_class());
        $this->addHeader('Authorization', 'Bearer ' . config("globals.security_key"));
        return $this->sendPostSecuredRequest($this->url, $payload);
    }
}
