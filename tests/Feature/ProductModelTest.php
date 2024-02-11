<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_product_model_has_all_consts()
    {
        $this->assertEquals(Product::RELATIONS, ['ingredients']);
    }

    public function test_product_model_has_relations()
    {
        $product = Product::factory()->create();
        //$order = OrderRegister::factory()->create(['product_id' => $product->id, 'available_quantity' => 5]);
        //$ingredient = Ingredient::factory()->create(['product_id' => $product->id, 'order_register_id' => $order->id]);
        $this->assertInstanceOf(Collection::class, $product->ingredients);
    }
}
