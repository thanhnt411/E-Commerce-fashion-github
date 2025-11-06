<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getSaleProduct($limit = 8)
    {
        return $this->model->whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->take($limit)->get();
    }

    public function getFeatureProduct($limit = 8)
    {
        return $this->model->where('featured', 1)->take($limit)->get();
    }

    public function search($query, $limit = 8)
    {
        return $this->model->where('name', 'LIKE', "%{$query}%")->take($limit)->get();
    }

    public function filtersProducts($f_brands, $f_categories, $min_price, $max_price, $o_colum, $o_order, $size)
    {
        return $this->model->where(function ($query) use ($f_brands) {
            $query->whereIn('brand_id', explode(',', $f_brands))->orWhereRaw("'" . $f_brands . "'=''");
        })
            ->where(function ($query) use ($f_categories) {
                $query->whereIn('category_id', explode(',', $f_categories))->orWhereRaw("'" . $f_categories . "'=''");
            })
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereBetween('regular_price', [$min_price, $max_price])->orWhereBetween('sale_price', [$min_price, $max_price]);
            })
            ->orderBy($o_colum, $o_order)->paginate($size);
    }

    public function getProductSlug($product_slug)
    {
        return $this->model->where('slug', $product_slug)->firstOrFail();
    }

    public function getProductsNotEqualSlug($product_slug, $limit = 8)
    {
        return $this->model->where('slug', '<>', $product_slug)->take($limit)->get();
    }
}
