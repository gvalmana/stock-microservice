<?php
namespace App\Http\UseCases\implementations;

use App\Helpers\FulledOrderMessage;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\Repositories\IOrderRegisterRepository;
use Illuminate\Support\Facades\Log;
use Junges\Kafka\Facades\Kafka;
use Junges\Kafka\Message\Message;
final class SendOrderRegisterNotificationKafkaProducer implements ISendOrderRegisterNotification
{
    private $configuration;
    private $orderRegisterRepository;
    public function __invoke(array $data)
    {
        return $this->notify($data);
    }
    public function __construct(IOrderRegisterRepository $orderRegisterRepository)
    {
        $this->orderRegisterRepository = $orderRegisterRepository;
    }

    public function notify($data)
    {
        $messageInfo = [
            'order_code' => $data['code'],
            'products' => $data['products']
        ];
        $this->configuration = new FulledOrderMessage($messageInfo);
        $message = new Message(
            body: $this->configuration->getBody(),
            key: $this->configuration->getKey(),
        );
        $publisher = Kafka::publishOn($this->configuration->getTopic())->withMessage($message);
        $publisher->send();
        $this->orderRegisterRepository->setDeliveredStatus($data['code']);
    }
}
