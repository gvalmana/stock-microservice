<?php

namespace App\Models\Repositories;

use App\Models\OrderRegister;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderRegisterRepository extends ListRepository implements IOrderRegisterRepository
{
    public function __construct()
    {
        parent::__construct(OrderRegister::class);
    }
    public function register(array $data)
    {
        return DB::transaction(function () use ($data) {
            $ingredients = $data['products'];
            $order = OrderRegister::create([
                'code' => $data['order_code'],
                'fulled' => false
            ]);

            try {
                foreach ($ingredients as $ingredient) {
                    $product = Product::where('name', $ingredient['name'])->firstOrFail();
                    $order->ingredients()->create([
                        'product_id' => $product->id,
                        'quantity' => $ingredient['quantity'],
                    ]);
                }
            } catch (Exception $ex) {
                Log::error($ex->getMessage());
            }
            return $order;
        });
    }
}
