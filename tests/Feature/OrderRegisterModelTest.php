<?php

namespace Tests\Feature;

use App\Models\Ingredient;
use App\Models\OrderRegister;
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
        $this->assertEquals(OrderRegister::RELATIONS, ['ingredients']);
    }

    public function test_order_register_model_has_relations()
    {
        $this->seed();
        $order = OrderRegister::factory()->create();
        Ingredient::factory(4)->create([
            'order_register_id' => $order->id
        ]);
        $this->assertInstanceOf(Collection::class, $order->ingredients);
    }

    public function test_order_register_attribute_fullfilled()
    {
        $order = OrderRegister::factory()->create();
        Ingredient::factory(4)->create([
            'order_register_id' => $order->id,
            'fulled' => true
        ]);

        $this->assertTrue($order->fulled);
    }

    public function test_order_register_attribute_not_fullfilled()
    {
        $order = OrderRegister::factory()->create();
        Ingredient::factory(4)->create([
            'order_register_id' => $order->id,
            'fulled' => false
        ]);

        $this->assertFalse($order->fulled);
    }
}
