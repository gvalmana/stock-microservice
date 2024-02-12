<?php

namespace Tests\Feature;

use App\Events\OrderRegisterFulled;
use App\Http\UseCases\implementations\SendOrderRegisterNotification;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationHttp;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationTest;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Listeners\OrderRegisterFulledListener;
use App\Models\Ingredient;
use App\Models\OrderRegister;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Queue\Listener;
use Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;

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
        Event::assertListening(OrderRegisterFulled::class, OrderRegisterFulledListener::class);
    }

    public function test_event_notification_http_sent()
    {
        $this->app->bind(ISendOrderRegisterNotification::class, SendOrderRegisterNotificationHttp::class);
        $url = config("globals.delivery_microservice.url").config("globals.delivery_microservice.webhook_order_path");
        Http::fake(
            [
                 $url => Http::response(["success"=>true,"type"=>"success","message"=>"","data"=>[]], 200),
            ]
        );
        Event::fake();
        $product = Product::factory()->create();
        $order = OrderRegister::factory()->create();
        Ingredient::factory()->create(['product_id' => $product->id, 'fulled' => true, 'order_register_id' => $order->id]);
        $this->assertTrue($order->fulled);
        OrderRegisterFulled::dispatch($order);
        Event::assertDispatched(OrderRegisterFulled::class);
        Event::assertListening(OrderRegisterFulled::class, OrderRegisterFulledListener::class);
    }

    public function test_notificator_http_works()
    {
        $url = config("globals.delivery_microservice.url").config("globals.delivery_microservice.webhook_order_path");
        Http::fake(
            [
                 $url => Http::response(["success"=>true,"type"=>"success","message"=>"","data"=>[]], 200),
            ]
        );
        $product = Product::factory()->create();
        $order = OrderRegister::factory()->create();
        Ingredient::factory()->create(['product_id' => $product->id, 'fulled' => true, 'order_register_id' => $order->id]);
        $notificator = $this->app->make(SendOrderRegisterNotificationHttp::class);
        $this->assertDatabaseHas('order_registers', ['delivered' => false,'code' => $order->code]);
        $notificator->notify($order->toArray());
        $this->assertTrue($order->fulled);
        $this->assertDatabaseHas('order_registers', ['delivered' => true,'code' => $order->code]);
    }
}
