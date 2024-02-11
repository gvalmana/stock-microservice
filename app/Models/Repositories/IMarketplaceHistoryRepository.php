<?php
namespace App\Models\Repositories;

interface IMarketplaceHistoryRepository
{
    public function listAll(array $params);
}
