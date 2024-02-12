<?php

namespace App\Models\Repositories\implementations;

use App\Models\Ingredient;
use App\Models\Repositories\IIngredientsRepository;
use App\Models\Repositories\ListRepository;

class IgredientsRepository extends ListRepository implements IIngredientsRepository
{
    public function __construct()
    {
        parent::__construct(Ingredient::class);
    }

    public function getIngredientsByOrder($order_code)
    {
        return $this->modelClass::join('order_registers', 'intgredients.order_register_id', '=', 'order_registers.id')
            ->where('order_registers.code', $order_code)->get();
    }

    public function getNotFulledIngredients()
    {
        return $this->modelClass::where('fulled', false)->orderBy('created_at','asc')->take(15)->get();
    }
}
