<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRegister extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'date',
        'code',
    ];

    public const RELATIONS = ['ingredients'];

    protected $appends = ['fulled'];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class, 'order_register_id', 'id');
    }

    public function getFulledAttribute()
    {
        return $this->ingredients()->where('fulled', true)->count() == $this->ingredients()->count();
    }
}
