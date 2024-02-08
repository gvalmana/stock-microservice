<?php

namespace Tests\Feature;

use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;

class ReciveOrderTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }
    public function test_order_of_products_can_be_recived()
    {
        $data = [
            'products' => [
                [
                    'name' => 'Tomato',
                    'quantity'=>1
                ]
            ],
            'order_code' => Str::uuid()->toString(),
        ];
        $response = $this->postJson(route('order.get'), $data);
        $response->assertSuccessful();
        $order = OrderRegister::first();
        $this->assertDatabaseCount('order_registers', 1);
        $this->assertDatabaseCount('ingredients', $order->ingredients->count());
        $this->assertEquals($order->products->count(), $order->ingredients->count());
        $this->assertFalse($order->fulled);
        $this->assertDatabaseHas('order_registers', ['code' => $data['order_code']]);
        $firstDataProductItem = $data['products'][0];
        $firstDataProductModel = Product::where('name', $firstDataProductItem['name'])->firstOrFail();
        $this->assertDatabaseHas('ingredients', [
            'order_register_id' => $order->id,
            'quantity' => $firstDataProductItem['quantity'],
            'product_id' => $firstDataProductModel->id
        ]);
    }
}
