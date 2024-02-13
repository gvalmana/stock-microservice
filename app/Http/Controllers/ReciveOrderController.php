<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Orders\GetOrderRequest;
use App\Http\UseCases\IRecibeOrder;
use App\Jobs\CheckProductsAvailableJob;
use App\Traits\HttpResponsable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
* @OA\Info(title="API Stock Microservice", version="1.0")
*
* @OA\Server(url="http://95.183.53.25:8001")
*/
class ReciveOrderController extends Controller
{

    use HttpResponsable;
    /**
     * @OA\Post(
     *     path="/api/orders/get-order",
     *     summary="Crear una orden de entrega",
     *     tags={"Stock"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              required={"order_code","products"},
     *              @OA\Property(property="order_code", type="string", example="2302faca-7f66-4078-86d4-abb0ab54b675"),
     *              @OA\Property(
     *                  property="products",
     *                  type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      required={"product"},
     *                      @OA\Property(property="product", type="string", example="Tomato"),
     *                      @OA\Property(property="quantity", type="integer", example=2),
     *                  ),
     *              ),
     *         ),
     *       ),
     *     @OA\Response(
     *         response=200,
     *         description="Orden actualizada",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="type", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Order created successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="code", type="string", example="2302faca-7f66-4078-86d4-abb0ab54b675"),
     * )
     *       )),
     *           ),
     *         )
     *     ),
     * )
     */
    public function __invoke(GetOrderRequest $request, IRecibeOrder $recibeOrders)
    {
        return $this->getOrders($request, $recibeOrders);
    }
    public function getOrders(GetOrderRequest $request, IRecibeOrder $recibeOrders)
    {
        $data = $recibeOrders($request->input());
        CheckProductsAvailableJob::dispatch($data);
        return $this->makeResponseOK([]);
    }
}
