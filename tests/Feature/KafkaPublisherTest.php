<?php

namespace Tests\Feature;

use App\Helpers\FulledOrderMessage;
use App\Helpers\StockOrderMessage;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationKafkaProducer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
use App\Models\OrderRegister;
use Illuminate\Support\Facades\Log;

class KafkaPublisherTest extends TestCase
{
    use RefreshDatabase;
    public function creating_order_with_kafka_message()
    {
        $this->seed();
        Kafka::fake();
        $order = OrderRegister::factory()->create(['code' => '123']);
        $publicher = $this->app->make(SendOrderRegisterNotificationKafkaProducer::class);
        $publicher->notify($order);
        Kafka::assertPublishedOn(FulledOrderMessage::TOPIC, null, function(Message $message) use($order){
            $key_correct = $message->getKey() === $order->code;
            $boddy_keys = array_key_exists('order_code', $message->getBody()['data']);
            $event_type = array_key_exists('event', $message->getBody());
            $order_id_correct = $message->getBody()['data']['order_code'] === $order->code;
            return $key_correct && $boddy_keys && $order_id_correct && $event_type;
        });
    }
}
