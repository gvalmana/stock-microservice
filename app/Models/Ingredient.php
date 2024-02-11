<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use ReflectionClass;

class Ingredient extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingredients';

    public const RELATIONS = ['order','product'];

    protected $fillable = [
        'quantity',
        'fulled',
        'order_register_id',
        'product_id'
    ];

    protected $casts = [
        'fulled' => 'boolean'
    ];

    public function order()
    {
        return $this->belongsTo(OrderRegister::class, 'order_register_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
