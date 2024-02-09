<?php
namespace App\Http\UseCases;

use App\Models\Ingredient;

interface IBuyProduct
{
    public function buyProduct($data);
}
