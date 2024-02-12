<?php
namespace App\Models\Repositories;

interface IOrderRegisterRepository
{
    public function register(array $params);
    public function setDeliveredStatus($order_code);
    public function getNotDeliveredOrders();
}
