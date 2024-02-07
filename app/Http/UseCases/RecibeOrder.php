<?php
namespace App\Http\UseCases;

use Illuminate\Foundation\Http\FormRequest;

interface RecibeOrder
{
    public function getOrder(FormRequest $request);
}
