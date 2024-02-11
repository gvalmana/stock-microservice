<?php

namespace App\Providers;

use App\Adapters\DeliveryConector;
use App\Adapters\implementations\AlegriaMarketConector;
use App\Adapters\implementations\AlegriaMarketConectorTest;
use App\Adapters\implementations\DeliveryConectorImpl;
use App\Adapters\MarketConector;
use App\Http\UseCases\IBuyProduct;
use App\Http\UseCases\IMarketplaceHistory;
use App\Http\UseCases\implementations\BuyProductImpl;
use App\Http\UseCases\implementations\MarketplaceHistoryImpl;
use App\Http\UseCases\implementations\RecibeOrderImpl;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationHttp;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationKafkaProducer;
use App\Http\UseCases\implementations\SendOrderRegisterNotificationTest;
use App\Http\UseCases\IRecibeOrder;
use App\Http\UseCases\ISendOrderRegisterNotification;
use App\Models\Ingredient;
use App\Models\Repositories\IIngredientsRepository;
use App\Models\Repositories\IMarketplaceHistoryRepository;
use App\Models\Repositories\implementations\IgredientsRepository;
use App\Models\Repositories\implementations\MarketplaceHistoryRepository;
use App\Models\Repositories\IOrderRegisterRepository;
use App\Models\Repositories\implementations\OrderRegisterRepository;
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
        App::singleton(MarketConector::class,function(){
            if (config("globals.marketplace.available")==0) {
                return new AlegriaMarketConectorTest();
            }
            return new AlegriaMarketConector();
        });
        App::bind(ISendOrderRegisterNotification::class, function(){
            if (config("globals.comunication_protocol")=="kafka") {
                return new SendOrderRegisterNotificationKafkaProducer();
            } elseif (config("globals.comunication_protocol")=="http") {
                return new SendOrderRegisterNotificationHttp(app(DeliveryConector::class), app(IOrderRegisterRepository::class));
            } else {
                return new SendOrderRegisterNotificationTest();
            }
        });
        App::singleton(IRecibeOrder::class, RecibeOrderImpl::class);
        App::bind(IBuyProduct::class, BuyProductImpl::class);
        App::bind(IOrderRegisterRepository::class, OrderRegisterRepository::class);
        App::bind(IMarketplaceHistoryRepository::class, MarketplaceHistoryRepository::class);
        App::bind(IMarketplaceHistory::class, MarketplaceHistoryImpl::class);
        App::bind(ISendOrderRegisterNotification::class, SendOrderRegisterNotificationHttp::class);
        App::bind(DeliveryConector::class, DeliveryConectorImpl::class);
        App::bind(IIngredientsRepository::class, IgredientsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
