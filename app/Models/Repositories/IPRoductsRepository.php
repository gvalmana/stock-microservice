<?php
namespace App\Models\Repositories;

interface IPRoductsRepository
{
    public function getProductsWithoutStock();
    public function addStock($product, $quantity);
}
