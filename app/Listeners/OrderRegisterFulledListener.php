<?php

namespace App\Listeners;

use App\Events\OrderRegisterFulled;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\OrderRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderRegisterFulledListener
{
    public ISendOrderRegisterNotification $notification;
    public function __construct(ISendOrderRegisterNotification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Handle the event.
     */
    public function handle(OrderRegisterFulled $event): void
    {
        $this->notification->notify($event->order);
    }
}
