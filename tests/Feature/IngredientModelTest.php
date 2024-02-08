<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\OrderRegister;
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
        $this->assertEquals(Ingredient::RELATIONS, ['order']);
    }

    public function test_order_register_model_has_relations()
    {
        $this->seed();
        $order = OrderRegister::factory()->create();
        $ingredient = Ingredient::factory()->create([
            'order_register_id' => $order->id
        ]);
        $this->assertInstanceOf(OrderRegister::class, $ingredient->order);
    }
}
