<?php

namespace App\Adapters\implementations;

use App\Adapters\BaseAdapter;
use App\Adapters\DeliveryConector;

final class DeliveryConectorImpl extends BaseAdapter implements DeliveryConector
{
    private $url;
    public function __construct()
    {
        parent::__construct();
        $this->url = config("globals.delivery_microservice.url");
    }
    public function notifyUpdate($data)
    {
        $response = $this->sendPostSecuredRequest($this->url, $data);
        return $response;
    }
}
