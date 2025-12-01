<?php

namespace App\Interfaces\Services;

use App\Models\Brand;

interface AdminServiceInterface
{
    public function getOrderCreatedDESC();

    public function selectTotal();

    public function getBrandIdDESC();

    public function storeBrand(array $data, $imgFile);

    public function updateBrand(Brand $brand,  array $data, $imgFile);

    public function getBrandId($id);
}
