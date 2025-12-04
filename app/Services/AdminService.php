<?php

namespace App\Services;

use App\Models\Brand;
use Illuminate\Support\Facades\DB;
use App\Interfaces\Services\AdminServiceInterface;
use App\Interfaces\Repositories\BrandRepositoryInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;

class AdminService implements AdminServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected FileService $fileService,
        protected OrderRepositoryInterface $orderRepo,
        protected BrandRepositoryInterface $brandRepo
    ) {
        //
    }

    public function getOrderCreatedDESC()
    {
        return $this->orderRepo->getOrderCreatedDESC();
    }

    public function selectTotal()
    {
        return DB::select("Select sum(total) As TotalAmount,
                                    sum(if(status = 'ordered', total, 0)) As TotalOrderedAmount,
                                    sum(if(status = 'delivered', total, 0)) As TotalDeliveredAmount,
                                    sum(if(status = 'canceled', total, 0)) As TotalCanceledAmount,
                                    Count(*) As Total,
                                    sum(if(status = 'ordered', 1, 0)) As TotalOrdered,
                                    sum(if(status = 'delivered', 1, 0)) As TotalDelivered,
                                    sum(if(status = 'canceled', 1, 0)) As TotalCanceled
                                    From  Orders 
                                    ");
    }
}
