<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class ShopService
{
    /**
     * Create a new class instance.
     */
    protected $productRepo, $categoryRepo, $brandRepo;
    public function __construct(
        ProductRepository $productRepo,
        CategoryRepository $categoryRepo,
        BrandRepository $brandRepo,
    ) {
        $this->productRepo = $productRepo;
        $this->categoryRepo = $categoryRepo;
        $this->brandRepo = $brandRepo;
    }

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
