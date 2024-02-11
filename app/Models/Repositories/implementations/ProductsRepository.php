<?php

namespace App\Models\Repositories\implementations;

use App\Models\MarketRequest;
use App\Models\Product;
use App\Models\Repositories\IMarketplaceHistoryRepository;
use App\Models\Repositories\IPRoductsRepository;
use App\Models\Repositories\ListRepository;

class ProductsRepository extends ListRepository implements IPRoductsRepository
{
    public function __construct()
    {
        parent::__construct(Product::class);
    }

    public function getProductsWithoutStock()
    {
        return Product::where('available_quantity', '<', 5)->get();
    }

    public function addStock($product, $quantity)
    {
        $product->update([
            'available_quantity' => $product->available_quantity + $quantity
        ]);
    }
}
