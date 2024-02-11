<?php

namespace App\Models\Repositories\implementations;

use App\Http\UseCases\IMarketplaceHistory;
use App\Models\MarketRequest;
use App\Models\Repositories\IMarketplaceHistoryRepository;
use App\Models\Repositories\ListRepository;

class MarketplaceHistoryRepository extends ListRepository implements IMarketplaceHistoryRepository
{
    public function __construct()
    {
        parent::__construct(MarketRequest::class);
    }
}
