<?php

namespace App\Observers;

use App\Models\Ingredient;
use Illuminate\Support\Facades\Log;

class IngredientObserver
{
    public function updated(Ingredient $model): void
    {
        if ($model->quantity < 5) {
        }
    }
}
