<?php

namespace App\Adapters\implementations;

use App\Adapters\MarketConector;
use App\Adapters\BaseAdapter;


final class AlegriaMarketConector extends BaseAdapter implements MarketConector
{
    private string $url;
    public function __construct(){
        parent::__construct();
        $this->url = config('stockproviders.alegra.url');
    }
    public function buyProduct($data)
    {
        $response = $this->sendPostPublicRequest($this->url, $data);
        return $response;
    }
}
