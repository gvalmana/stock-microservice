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
        $url = config("globals.delivery_microservice.url")."/".config("globals.delivery_microservice.webhook_order_path");
        Http::fake(
            [
                 $url => Http::response(["success"=>true,"type"=>"success","message"=>"","data"=>[]], 200),
            ]
        );
        $this->app->bind(MarketConector::class, AlegriaMarketConectorTest::class);
        $data = [
            'data' => [
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
            ]
        ];
        $response = $this->postJson(route('order.get'), $data,['Authorization' => 'Bearer ' . config('globals.security_key')]);
        $response->assertSuccessful();
        $order = OrderRegister::first();
        $this->assertDatabaseCount('order_registers', 1);
        $this->assertDatabaseCount('ingredients', $order->ingredients->count());
        $this->assertEquals($order->products->count(), $order->ingredients->count());
        $code = $data['data']['order_code'];
        $this->assertEquals($code, $order->code);
        $this->assertDatabaseHas('order_registers', ['code' => $code]);
        $firstDataProductItem = $data['data']['products'][0];
        $firstDataProductModel = Product::where('name', $firstDataProductItem['name'])->firstOrFail();
        $this->assertDatabaseHas('ingredients', [
            'order_register_id' => $order->id,
            'quantity' => $firstDataProductItem['quantity'],
            'product_id' => $firstDataProductModel->id
        ]);
        $secondDataProductItem = $data['data']['products'][1];
        $secondDataProductModel = Product::where('name', $secondDataProductItem['name'])->firstOrFail();
        $this->assertDatabaseHas('ingredients', [
            'order_register_id' => $order->id,
            'quantity' => $secondDataProductItem['quantity'],
            'product_id' => $secondDataProductModel->id
        ]);
    }

    public function test_order_of_products_is_paused()
    {
        $this->app->bind(MarketConector::class, AlegriaMarketConectorTest::class);
        $data = [
            'data' => [
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
            ]
        ];
        $response = $this->postJson(route('order.get'), $data,['Authorization' => 'Bearer ' . config('globals.security_key')]);
        $response->assertSuccessful();
        $order = OrderRegister::first();
        $this->assertDatabaseCount('order_registers', 1);
        $this->assertDatabaseCount('ingredients', $order->ingredients->count());
        $this->assertEquals($order->products->count(), $order->ingredients->count());
        $code = $data['data']['order_code'];
        $this->assertEquals($code, $order->code);
        $this->assertDatabaseHas('order_registers', ['code' => $code]);
        $firstDataProductItem = $data['data']['products'][0];
        $firstDataProductModel = Product::where('name', $firstDataProductItem['name'])->firstOrFail();
        $this->assertDatabaseHas('ingredients', [
            'order_register_id' => $order->id,
            'quantity' => $firstDataProductItem['quantity'],
            'product_id' => $firstDataProductModel->id
        ]);
    }
}
