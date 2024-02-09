<?php
namespace App\Http\UseCases\implementations;

use App\Http\UseCases\IMarketplaceHistory;
use App\Models\Repositories\IMarketplaceHistoryRepository;

class MarketplaceHistoryImpl implements IMarketplaceHistory
{
    private IMarketplaceHistoryRepository $repository;
    public function __construct(IMarketplaceHistoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getMarketplaceHistory($params)
    {
        return $this->repository->listAll($params);
    }
}

