<?php

namespace App\Providers;

use App\Adapters\implementations\AlegriaMarketConector;
use App\Adapters\MarketConector;
use App\Http\UseCases\RecibeOrder;
use App\Http\UseCases\RecibeOrderImpl;
use App\Models\Ingredient;
use App\Models\Repositories\IOrderRegisterRepository;
use App\Models\Repositories\OrderRegisterRepository;
use App\Observers\IngredientObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        App::singleton(MarketConector::class, AlegriaMarketConector::class);
        App::singleton(RecibeOrder::class, RecibeOrderImpl::class);
        App::bind(IOrderRegisterRepository::class, OrderRegisterRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
