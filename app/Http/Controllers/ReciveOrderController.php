<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\GetOrderRequest;
use App\Http\UseCases\IRecibeOrder;
use App\Jobs\CheckProductsAvailableJob;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReciveOrderController extends Controller
{

    public function __invoke(GetOrderRequest $request, IRecibeOrder $recibeOrders)
    {
        return $this->getOrders($request, $recibeOrders);
    }
    public function getOrders(GetOrderRequest $request, IRecibeOrder $recibeOrders)
    {
        $data = $recibeOrders($request->input());
        CheckProductsAvailableJob::dispatch($data);
        return response()->json(["message"=>"success"],200);
    }
}
