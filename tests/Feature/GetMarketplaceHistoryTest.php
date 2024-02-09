<?php

namespace Tests\Feature;

use Database\Seeders\MarketRequestTestSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetMarketplaceHistoryTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_get_marketplace_history()
    {
        $this->seed(MarketRequestTestSeeder::class);
        $response = $this->getJson(route('history.marketplace.index'));
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'type',
            'data' => [
                '*' => [
                    'status',
                    'code',
                    'recipe',
                    'delivery_date',
                ],
            ],
            'links'=>[
                'total',
                'count',
                'pagination',
                'page',
                'lastPage',
                'hasMorePages',
                'nextPageUrl',
                'previousPageUrl',
                '_links'
            ],
        ]);
        $response->assertJsonCount(10, 'data');
    }
}
