<?php

namespace App\Console\Commands;

use App\Adapters\MarketConector;
use App\Http\UseCases\IBuyProduct;
use App\Models\Repositories\IPRoductsRepository;
use App\Traits\LogAndOutputTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CheckProducitsInventory extends Command
{
    use LogAndOutputTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-producits-inventory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(IPRoductsRepository $productsRepository, MarketConector $buyer)
    {
        $this->logAndOutput('Checking products inventory...');
        $productsRepository->getProductsWithoutStock()->each(function ($product) use ($buyer, $productsRepository) {
            $this->logAndOutput('Buying product: ' . $product->name);
            $data = $buyer->buyProduct($product->name);
            $this->logAndOutput("Product {$product->name} sold: ". json_encode($data));
            $productsRepository->addStock($product, $data->quantitySold);
        });
        $this->logAndOutput('Finished!');
        Artisan::call('app:check-not-fulled-ingredients-command');
    }
}
