<?php

namespace App\Models\Repositories;

use App\Http\UseCases\IMarketplaceHistory;
use App\Models\MarketRequest;

class MarketplaceHistoryRepository extends ListRepository implements IMarketplaceHistoryRepository
{
    public function __construct()
    {
        parent::__construct(MarketRequest::class);
    }
}
