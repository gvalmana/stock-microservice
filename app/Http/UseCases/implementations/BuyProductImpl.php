<?php
namespace App\Http\UseCases\implementations;

use App\Adapters\MarketConector;
use App\Http\UseCases\IBuyProduct;
use App\Models\Ingredient;
use App\Models\MarketRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

final class BuyProductImpl implements IBuyProduct
{
    private MarketConector $marketConector;
    public function __construct(MarketConector $marketConector)
    {
        $this->marketConector = $marketConector;
    }

    public function __invoke($data)
    {
        return $this->buyProduct($data);
    }

    public function buyProduct($data)
    {
        $dataRequest = [
            'ingredient' => $data->product->name,
        ];
        $response = $this->marketConector->buyProduct($dataRequest);
        if (isset($response->quantitySold)) {
            MarketRequest::create([
                'product_id' => $data->product->id,
                'quantity_sold' => $response->quantitySold
            ]);

            $data->product->update([
                'available_quantity' => $data->product->available_quantity + $response->quantitySold
            ]);
        }
    }
}
