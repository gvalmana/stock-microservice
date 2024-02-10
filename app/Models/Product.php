<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use ReflectionClass;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    public const INGREDIENT_TOMATO = 'Tomato';
    public const INGREDIENT_LEMON = 'Lemon';
    public const INGREDIENT_POTATO = 'Potato';
    public const INGREDIENT_RICE = 'Rice';
    public const INGREDIENT_KETCHUN = 'Ketchup';
    public const INGREDIENT_ONION = 'Onion';
    public const INGREDIENT_CHEESE = 'Cheese';
    public const INGREDIENT_MEAT = 'Meat';
    public const INGREDIENT_CHICKEN = 'Chicken';
    public const RELATIONS = ['ingredients'];
    protected $fillable = [
        'name',
        'available_quantity',
    ];
    protected $hidden = [
        'deleted_at',
        'created_at',
        'updated_at',
    ];
    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'product_id', 'id');
    }

    public static function getNamesConstants() {
        $refl = new ReflectionClass(get_called_class());
        $constants = $refl->getConstants();
        $filteredConstants = [];

        foreach ($constants as $constant => $value) {
            if (strpos($constant, 'INGREDIENT_') === 0) {
                $filteredConstants[] = $value;
            }
        }

        return $filteredConstants;
    }
}
