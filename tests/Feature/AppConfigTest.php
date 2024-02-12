<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AppConfigTest extends TestCase
{
    public function test_developement_config()
    {
        $this->assertNotNull(config("globals"));
        $this->assertNotEmpty(config("globals.delivery_microservice.url"));
        $this->assertNotEmpty(config("globals.marketplace.url"));
        $this->assertNotEmpty(config("globals.delivery_microservice.webhook_order_path"));
        $this->assertEquals('/webhooks/orders',config("globals.delivery_microservice.webhook_order_path"));
        $this->assertNotEmpty(config("globals.comunication_protocol"));
        $this->assertNotNull(config("globals.security_key"));
    }
}
