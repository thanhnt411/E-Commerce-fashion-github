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
}
