<?php
namespace App\Http\UseCases;

use Illuminate\Foundation\Http\FormRequest;

interface IRecibeOrder
{
    public function getOrder(array $request);
}
