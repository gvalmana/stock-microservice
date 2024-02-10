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
        $this->url = config("globals.delivery_microservice.url")."/".config("globals.delivery_microservice.webhook_order_path");
    }
    public function notifyUpdate($data)
    {
        Log::debug('Starting Order Register Fulled Notification: '. json_encode($data) . ' - '.get_called_class());
        return $this->sendPostSecuredRequest($this->url, $data);
    }
}
