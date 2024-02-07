<?php

namespace Tests\Feature\orders;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetOrdersTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }
    public function test_buy_order_can_be_recived(): void
    {
        $data = [];
        $response = $this->postJson(route('order.get'), $data);
        $response->assertSuccessful();
    }
}
