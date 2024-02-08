<?php

namespace Tests\Feature;

use App\Models\MarketRequest;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MarquetRequestModelTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_marquet_request_has_constans_model()
    {
        $this->assertEquals(MarketRequest::RELATIONS, ['product']);
    }

    public function test_market_request_models_has_relations()
    {
        $this->seed();
        $product = Product::first();
        $marketRequest = MarketRequest::factory()->create(['product_id'=>$product->id]);
        $this->assertInstanceOf(Product::class, $marketRequest->product);
    }
}
