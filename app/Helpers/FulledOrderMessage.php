<?php
namespace App\Helpers;

class FulledOrderMessage extends KafkaMessageStructure
{
    public const TOPIC = 'stock-order-update';

    public function __construct(array $data)
    {
        $this->data = $data;
        parent::__construct($data);
        $this->setTopic(self::TOPIC);
        $this->setKey($data['order_code']);
    }

    public function getBody(): array
    {
        return [
            'event' => 'update_cooking_status',
            'date'=>$this->date,
            'data'=>['order_code'=>$this->data['order_code']]
        ];
    }
}
