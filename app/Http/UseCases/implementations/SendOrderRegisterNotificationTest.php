<?php
namespace App\Http\UseCases\implementations;

use App\Http\UseCases\ISendOrderRegisterNotification;
use Illuminate\Support\Facades\Log;

class SendOrderRegisterNotificationTest implements ISendOrderRegisterNotification
{
    public function __invoke($data)
    {
        return $this->notify($data);
    }
    public function notify($data)
    {
        Log::debug('Order Register Fulled: '.$data->code . ' - '.get_called_class());
    }
}
