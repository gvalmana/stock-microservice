<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_ingredient_has_all_consts()
    {
        $this->assertEquals(Ingredient::RELATIONS, ['order', 'product']);
    }

    public function test_order_register_model_has_relations()
    {
        $this->seed();
        $order = OrderRegister::factory()->create();
        $product = Product::factory()->create();
        $ingredient = Ingredient::factory()->create([
            'order_register_id' => $order->id,
            'product_id' => $product->id
        ]);
        $this->assertInstanceOf(OrderRegister::class, $ingredient->order);
        $this->assertInstanceOf(Product::class, $ingredient->product);
    }
}
