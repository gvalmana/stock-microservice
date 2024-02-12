<?php

namespace App\Adapters\implementations;

use App\Adapters\MarketConector;
use App\Adapters\BaseAdapter;
use Illuminate\Support\Facades\Log;
use stdClass;

class AlegriaMarketConectorTest extends BaseAdapter implements MarketConector
{
    private string $url;
    public function __construct(){
        parent::__construct();
        $this->url = config('globals.marketplace.url');
    }
    public function buyProduct($data)
    {
        Log::debug("Comprando productos en le conector de testing ". get_called_class());
        $result = new stdClass();
        $quantitySold = random_int(0, 5);
        Log::debug("Se vendieron ".$quantitySold." productos");
        $result->quantitySold = $quantitySold;
        return $result;
    }
}
