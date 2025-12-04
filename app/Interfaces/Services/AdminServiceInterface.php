<?php

namespace App\Interfaces\Services;

use App\Models\Brand;

interface AdminServiceInterface
{
    public function getOrderCreatedDESC();

    public function selectTotal();
}
