<?php

namespace App\Services;

use App\Interfaces\Repositories\BrandRepositoryInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Services\ShopServiceInterface;


class ShopService implements ShopServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected ProductRepositoryInterface $productRepo,
        protected CategoryRepositoryInterface $categoryRepo,
        protected BrandRepositoryInterface $brandRepo,
    ) {}

    public function getShopData()
    {
        return [
            'categories' => $this->categoryRepo->getFirstCategory(),
            'brands' => $this->brandRepo->getFirstBrand(),
        ];
    }

    public function getFiltersProducts($filters)
    {
        $orderOption = [
            1 => ['created_at', 'DESC'],
            2 => ['created_at', 'ASC'],
            3 => ['sale_price', 'DESC'],
            4 => ['sale_price', 'ASC'],
        ];

        [$o_colum, $o_order] = $orderOption[$filters['order']] ?? ['id', 'DESC'];


        return $this->productRepo->filtersProducts(
            $filters['f_brands'],
            $filters['f_categories'],
            $filters['min_price'],
            $filters['max_price'],
            $o_colum,
            $o_order,
            $filters['size'],
        );
    }

    public function getProductSlug($product_slug)
    {
        return $this->productRepo->getProductSlug($product_slug);
    }

    public function getProductsNotEqualSlug($product_slug)
    {
        return $this->productRepo->getProductsNotEqualSlug($product_slug, 8);
    }
}
