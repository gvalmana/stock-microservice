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
    public function index(Request $request, IMarketplaceHistory $service)
    {
        $params = $this->processParams($request);
        $models = $service->getMarketplaceHistory($params);
        $links = $this->makeMetaData($models);
        return $this->makeResponseList(MarkeplaceResource::collection($models), $links);
    }
}
