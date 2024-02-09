<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class MarketRequest extends Model
{
    use HasFactory, SoftDeletes;

    const RELATIONS = ['product'];

    protected $fillable = [
        'product_id',
        'quantity_sold',
        'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected static function booted()
    {
        static::creating(function (MarketRequest $model) {
            $model->date = Carbon::now();
        });
    }
}
