<?php

namespace App\Interfaces\Services;

interface ShopServiceInterface
{
    public function getShopData();
    public function getFiltersProducts($filters);
    public function getProductSlug($product_slug);
    public function getProductsNotEqualSlug($product_slug);
}
