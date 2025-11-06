<?php

namespace App\Repositories;

use App\Models\Brand;

class BrandRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct(Brand  $model)
    {
        $this->model = $model;
    }

    public function getFirstBrand()
    {
        return $this->model->orderBy('name', 'ASC')->get();
    }
}
