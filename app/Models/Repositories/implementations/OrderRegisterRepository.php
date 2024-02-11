<?php

namespace App\Models\Repositories\implementations;

use App\Models\Ingredient;
use App\Models\OrderRegister;
use App\Models\Product;
use App\Models\Repositories\IOrderRegisterRepository;
use App\Models\Repositories\ListRepository;
use Exception;
use Illuminate\Support\Carbon;
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
            $ingredients = $data['data']['products'];
            $code = $data['data']['order_code'];
            $order = $this->modelClass::create([
                'code' => $code,
            ]);
            foreach ($ingredients as $ingredient) {
                $product = Product::where('name', $ingredient['name'])->first();
                Log::debug('Producto: ' . $product->name);
                $ingredient = Ingredient::create([
                    'product_id' => $product->id,
                    'quantity' => $ingredient['quantity'],
                    'order_register_id' => $order->id
                ]);
            }
            return $order;
        });
    }

    public function setDeliveredStatus($order_code)
    {
        $order = $this->modelClass::where('code', $order_code)->first();
        $order->delivered = true;
        $order->delivery_at = Carbon::now();
        $order->save();
    }
}
