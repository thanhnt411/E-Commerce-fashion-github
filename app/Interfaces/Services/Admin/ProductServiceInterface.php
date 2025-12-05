<?php

namespace App\Interfaces\Services\Admin;

use App\Models\Product;

interface ProductServiceInterface
{
    public function getLatestProduct();

    public function selectCategory();

    public function selectBrand();

    public function storeProduct(array $data, $primaryImg, $galleryImg);

    public function updateProduct(Product $product, array $data, $primaryImg, $galleryImg);

    public function deleteProduct(Product $product);
}
