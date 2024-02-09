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

    public function __invoke(array $params)
    {
        return $this->getMarketplaceHistory($params);
    }

    public function getMarketplaceHistory(array $params)
    {
        return $this->repository->listAll($params);
    }
}

