<?php
namespace App\Http\UseCases;

interface ISendOrderRegisterNotification
{
    public function notify($data);
}
