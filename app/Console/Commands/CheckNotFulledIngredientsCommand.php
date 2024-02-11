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
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-not-fulled-ingredients-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(IIngredientsRepository $ingredientsRepository, IBuyProduct $buyProduct)
    {
        $this->logAndOutput('Checking not fulled ingredients...');
        $ingredients = $ingredientsRepository->getNotFulledIngredients();
        foreach ($ingredients as $ingredient) {
            $buyProduct($ingredient);
        }
        $this->logAndOutput('Done!');
    }
}
