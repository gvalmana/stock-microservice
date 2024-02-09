<?php
namespace App\Http\UseCases\implementations;

use App\Http\UseCases\IRecibeOrder;
use App\Models\OrderRegister;
use App\Models\Product;
use App\Models\Repositories\IOrderRegisterRepository;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class RecibeOrderImpl implements IRecibeOrder
{
    private IOrderRegisterRepository $repository;
    public function __construct(IOrderRegisterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOrder(array $data)
    {
        return $this->repository->register($data);
    }
}
