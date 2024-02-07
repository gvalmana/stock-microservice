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
        'is_fullfilled',
        'ingredient_id',
    ];
}
