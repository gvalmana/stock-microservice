<?php

namespace Tests\Feature;

use App\Adapters\implementations\AlegriaMarketConectorTest;
use App\Adapters\MarketConector;
use App\Models\OrderRegister;
use App\Models\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Support\Str;

class ReciveOrderTest extends TestCase
{
    use RefreshDatabase;
    private $faker;
    public function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        $this->seed();
    }
    public function test_order_of_products_can_be_recived()
    {
        $this->app->bind(MarketConector::class, AlegriaMarketConectorTest::class);
        $data = [
            'products' => [
                [
                    'name' => $this->faker->randomElement(Product::getNamesConstants()),
                    'quantity' => random_int(1, 5)
                ],
                [
                    'name' => $this->faker->randomElement(Product::getNamesConstants()),
                    'quantity' => random_int(1, 5)
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
        $this->assertDatabaseHas('order_registers', ['code' => $data['order_code']]);
        $firstDataProductItem = $data['products'][0];
        $this->assertTrue($order->fulled);
        $firstDataProductModel = Product::where('name', $firstDataProductItem['name'])->firstOrFail();
        $this->assertDatabaseHas('ingredients', [
            'order_register_id' => $order->id,
            'quantity' => $firstDataProductItem['quantity'],
            'product_id' => $firstDataProductModel->id
        ]);
    }

    public function test_order_of_products_is_paused()
    {
        $this->app->bind(MarketConector::class, AlegriaMarketConectorTest::class);
        $data = [
            'products' => [
                [
                    'name' => $this->faker->randomElement(Product::getNamesConstants()),
                    'quantity' => random_int(6, 10)
                ],
                [
                    'name' => $this->faker->randomElement(Product::getNamesConstants()),
                    'quantity' => random_int(6, 10)
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
        $this->assertDatabaseHas('order_registers', ['code' => $data['order_code']]);
        $firstDataProductItem = $data['products'][0];
        $this->assertFalse($order->fulled);
        $firstDataProductModel = Product::where('name', $firstDataProductItem['name'])->firstOrFail();
        $this->assertDatabaseHas('ingredients', [
            'order_register_id' => $order->id,
            'quantity' => $firstDataProductItem['quantity'],
            'product_id' => $firstDataProductModel->id
        ]);
    }
}
