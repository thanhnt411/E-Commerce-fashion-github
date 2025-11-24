<?php

namespace App\Interfaces\Repositories;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Product;

    public function getSaleProduct(int $limit);

    public function getFeatureProduct(int $limit);

    public function search($query, int $limit);

    public function filtersProducts($f_brands, $f_categories, $min_price, $max_price, $o_colum, $o_order, $size);

    public function getProductSlug($product_slug);

    public function getProductsNotEqualSlug($product_slug, int $limit);
}
