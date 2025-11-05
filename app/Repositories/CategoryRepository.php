<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function getLatesCategory($limit = 10)
    {
        return $this->model->orderBy('id', 'DESC')->take($limit)->get();
    }
}
