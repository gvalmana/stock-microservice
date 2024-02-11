<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class OrderRegister extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date',
        'code',
        'delivered',
        'delivery_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'delivered' => 'boolean',
        'fulled' => 'boolean',
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'delivery_at' => 'datetime'
    ];

    public const RELATIONS = ['ingredients','products'];

    protected $appends = ['fulled'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'order_register_id', 'id');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Ingredient::class, 'order_register_id', 'id', 'id', 'product_id');
    }

    public function getFulledAttribute()
    {
        return $this->ingredients()->where('fulled', true)->count() == $this->ingredients()->count();
    }

    public function scopeDelivered($query)
    {
        return $query->where('delivered', true);
    }

    public function scopeNotDelivered($query)
    {
        return $query->where('delivered', false);
    }

    public static function booted()
    {
        static::created(function (OrderRegister $model) {
            $model->date = Carbon::now();
        });
    }
}
