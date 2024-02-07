<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\GetOrderRequest;
use App\Http\UseCases\RecibeOrder;
use Exception;
use Illuminate\Http\Request;

class GetOrderController extends Controller
{

    public function getOrder(GetOrderRequest $request, RecibeOrder $service)
    {
        try {
            $data = $service->getOrder($request);
            return response()->json(["message"=>"success"],200);
        } catch (Exception $ex) {
            return response()->json(["message"=>$ex->getMessage()],500);
        }

    }
}
