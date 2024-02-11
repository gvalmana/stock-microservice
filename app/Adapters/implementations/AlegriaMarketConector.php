<?php

namespace App\Adapters\implementations;

use App\Adapters\MarketConector;
use App\Adapters\BaseAdapter;
use Illuminate\Support\Facades\Log;

class AlegriaMarketConector extends BaseAdapter implements MarketConector
{
    private string $url;
    public function __construct(){
        parent::__construct();
        $this->url = config('globals.marketplace.url');
    }
    public function buyProduct($data)
    {
        $response = $this->sendPostPublicRequest($this->url, $data);
        return $response;
    }
}
