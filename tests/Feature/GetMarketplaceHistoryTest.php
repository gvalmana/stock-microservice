<?php

namespace Tests\Feature;

use App\Models\MarketRequest;
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
                    'quantity_sold',
                    'product',
                    'date',
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
        $response->assertJsonCount(MarketRequest::count(), 'data');
    }

    public function test_get_marketplace_history_pagination()
    {
        $params = [
            'pagination' => [
                'page'=>2,
                'pageSize'=>1
            ]
        ];

        $this->seed(MarketRequestTestSeeder::class);
        $response = $this->getJson(route('history.marketplace.index').'?'.http_build_query($params));
        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'type',
            'data' => [
                '*' => [
                    'quantity_sold',
                    'product',
                    'date',
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
        $response->assertJsonCount(1, 'data');
        $response->assertJsonFragment(['page' => 2]);
        $response->assertJsonFragment(['total' => 2]);
        $response->assertJsonFragment(['pagination' => 1]);
    }
}
