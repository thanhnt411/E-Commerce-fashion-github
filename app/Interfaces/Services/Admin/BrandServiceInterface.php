<?php

namespace App\Interfaces\Services\Admin;

use App\Models\Brand;

interface BrandServiceInterface
{
    public function getBrandIdDESC();

    public function storeBrand(array $data, $imgFile);

    public function updateBrand(Brand $brand,  array $data, $imgFile);

    public function deleteBrand(Brand $brand);
}
