<?php

namespace App\Console\Commands;

use App\Http\UseCases\IBuyProduct;
use App\Models\Ingredient;
use App\Models\Repositories\IIngredientsRepository;
use App\Traits\LogAndOutputTrait;
use Illuminate\Console\Command;

class CheckNotFulledIngredientsCommand extends Command
{
    use LogAndOutputTrait;
    private IBuyProduct $buyProduct;
    public function __construct(IBuyProduct $buyProduct)
    {
        parent::__construct();
        $this->buyProduct = $buyProduct;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-not-fulled-ingredients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(IIngredientsRepository $ingredientsRepository)
    {
        $this->logAndOutput('Checking not fulled ingredients...');
        $ingredients = $ingredientsRepository->getNotFulledIngredients();
        $this->checkingIngredients($ingredients);
        $this->logAndOutput('Done!');
    }

    private function checkingIngredients($ingredients)
    {
        foreach ($ingredients as $ingredient) {
            $product = $ingredient->product;
            if ($product->available_quantity > $ingredient->quantity) {
                $this->logAndOutput('Ingredient '.$ingredient->product->name.' available');
                $ingredient->fulled = true;
                $ingredient->save();
                $product->available_quantity = $product->available_quantity - $ingredient->quantity;
                $product->save();
            } else {
                $this->logAndOutput('Ingredient '.$ingredient->product->name.' not available.');
                $this->logAndOutput('Buying product '.$ingredient->product->name);
                $this->buyProduct->buyProduct($ingredient);
            }
        }
    }
}
