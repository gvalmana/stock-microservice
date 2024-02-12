<?php
namespace App\Models\Repositories;

interface IIngredientsRepository
{
    public function getIngredientsByOrder($order_code);
    public function getNotFulledIngredients();
}
