<?php

namespace App\Http\Controllers;

use App\Http\Resources\MarkeplaceResource;
use App\Http\UseCases\IMarketplaceHistory;
use App\Traits\HttpResponsable;
use App\Traits\PaginationTrait;
use App\Traits\ParamsProcessTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MarkePlaceController extends Controller
{
    use HttpResponsable, PaginationTrait, ParamsProcessTrait;

    /**
     * @OA\Get(
     *     path="/api/marketplace/history",
     *     summary="Historial de compras",
     *     tags={"Stock"},
     *     @OA\Response(
     *         response=200,
     *         description="Listado de las compras solicitadas al marketplace",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example="true"),
     *             @OA\Property(property="type", type="string", example="success"),
     *             @OA\Property(property="data", type="array", @OA\Items(
     *              @OA\Property(property="quantity_sold", type="integer", example="1"),
     *              @OA\Property(property="date", type="string", example="2022-06-11T20:30:00.000000Z"),
     *              @OA\Property(
     *                  property="product",
     *                  type="object",
     *                  @OA\Property(property="id", type="number", example=1),
     *                  @OA\Property(property="name", type="string", example="Tomato"),
     *                  @OA\Property(property="available_quantity", type="number", example=5),
     * )
     *       )),
     *           ),
     *         )
     *     ),
     * )
     */
    public function __invoke(Request $request, IMarketplaceHistory $listMarketplaceHistory)
    {
        return $this->index($request, $listMarketplaceHistory);
    }
    public function index(Request $request, IMarketplaceHistory $listMarketplaceHistory)
    {
        $params = $this->processParams($request);
        $models = $listMarketplaceHistory($params);
        $links = $this->makeMetaData($models);
        return $this->makeResponseList(MarkeplaceResource::collection($models), $links);
    }
}
