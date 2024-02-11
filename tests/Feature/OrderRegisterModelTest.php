<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\OrderRegister;
use App\Models\Product;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderRegisterModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_order_register_model_has_all_consts()
    {
        $this->assertEquals(OrderRegister::RELATIONS, ['ingredients','products']);
    }

    public function test_order_register_model_has_relations()
    {
        $this->seed();
        $order = OrderRegister::factory()->create();
        $product = Product::first();
        Ingredient::factory(4)->create([
            'order_register_id' => $order->id,
            'product_id' => $product->id
        ]);
        $this->assertInstanceOf(Collection::class, $order->ingredients);
        $this->assertInstanceOf(Collection::class,$order->products);
    }

    public function test_order_register_attribute_fullfilled()
    {
        $this->seed();
        $order = OrderRegister::factory()->create();
        $product = Product::first();
        Ingredient::factory(4)->create([
            'order_register_id' => $order->id,
            'fulled' => true,
            'product_id' => $product->id
        ]);

        $this->assertTrue($order->fulled);
    }

    public function test_order_register_attribute_not_fullfilled()
    {
        $this->seed();
        $order = OrderRegister::factory()->create();
        $product = Product::first();
        Ingredient::factory(4)->create([
            'order_register_id' => $order->id,
            'fulled' => false,
            'product_id' => $product->id
        ]);

        $this->assertFalse($order->fulled);
    }
}
