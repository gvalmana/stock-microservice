<?php

namespace App\Observers;

use App\Events\OrderRegisterFulled;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class IngredientObserver
{
    public function updated(Ingredient $model): void
    {
        if ($model->order->fulled) {
            OrderRegisterFulled::dispatch($model->order);
        }
    }
}
