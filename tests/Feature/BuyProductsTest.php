<?php

namespace Tests\Feature;

use App\Adapters\implementations\AlegriaMarketConectorTest;
use App\Adapters\MarketConector;
use App\Http\UseCases\IBuyProduct;
use App\Http\UseCases\implementations\BuyProductImpl;
use App\Models\Ingredient;
use App\Models\MarketRequest;
use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BuyProductsTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_configurations_are_correct()
    {
        $url = config("globals.marketplace.url");
        $this->assertNotEmpty($url);
        $this->assertEquals("https://recruitment.alegra.com/api/farmers-market/buy", $url);
    }

    public function test_a_product_increes_its_stock()
    {
        $quantitySold = random_int(1, 100);
        Http::fake([
            config("globals.marketplace.url") => Http::response(["quantitySold" => $quantitySold], 200),
        ]);


        $useCase = new BuyProductImpl($this->app->make(MarketConector::class));
        $order = OrderRegister::factory()->create();
        $product = Product::factory()->create(['available_quantity' => 0]);
        $ingredient = Ingredient::factory()->create(['order_register_id' => $order->id, 'product_id' => $product->id]);
        $useCase->buyProduct($ingredient);
        $this->assertDatabaseCount('market_requests', 1);
        $this->assertDatabaseHas('market_requests', [
            'product_id' => $product->id,
            'quantity_sold' => $quantitySold
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'available_quantity' => $quantitySold
        ]);
    }

    public function test_a_product_notincrees_its_stock()
    {
        $quantitySold = 0;
        Http::fake([
            config("globals.marketplace.url") => Http::response(["quantitySold" => $quantitySold], 200),
        ]);


        $useCase = new BuyProductImpl($this->app->make(MarketConector::class));
        $order = OrderRegister::factory()->create();
        $product = Product::factory()->create(['available_quantity' => 0]);
        $ingredient = Ingredient::factory()->create(['order_register_id' => $order->id, 'product_id' => $product->id]);
        $useCase->buyProduct($ingredient);
        $this->assertDatabaseCount('market_requests', 1);
        $this->assertDatabaseHas('market_requests', [
            'product_id' => $product->id,
            'quantity_sold' => $quantitySold
        ]);
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'available_quantity' => $quantitySold
        ]);
    }
}
