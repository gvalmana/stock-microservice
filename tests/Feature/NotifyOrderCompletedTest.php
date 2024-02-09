<?php

namespace Tests\Feature;

use App\Events\OrderRegisterFulled;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationTest;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Listeners\OrderRegisterFulledListener;
use App\Models\Ingredient;
use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
class NotifyOrderCompletedTest extends TestCase
{

    use RefreshDatabase;

    public  function test_event_notification_dispached()
    {
        $this->app->bind(ISendOrderRegisterNotification::class, SendOrderRegisterNotificationTest::class);
        Event::fake();
        $product = Product::factory()->create();
        $order = OrderRegister::factory()->create();
        Ingredient::factory()->create(['product_id' => $product->id, 'fulled' => true, 'order_register_id' => $order->id]);
        $this->assertTrue($order->fulled);
        OrderRegisterFulled::dispatch($order);
        Event::assertDispatched(OrderRegisterFulled::class);
    }
}
