<?php
namespace App\Http\UseCases;
use App\Http\UseCases\RecibeOrder;
use Illuminate\Foundation\Http\FormRequest;

class RecibeOrderImpl implements RecibeOrder
{

    public function getOrder(FormRequest $request)
    {
        $data = $request->all();
    }
}
