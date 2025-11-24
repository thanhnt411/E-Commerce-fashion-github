<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Category $model) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Category
    {
        return $this->model->find($id);
    }

    public function getLatesCategory($limit = 10)
    {
        return $this->model->orderBy('id', 'DESC')->take($limit)->get();
    }

    public function getFirstCategory()
    {
        return $this->model->orderBy('name', 'ASC')->get();
    }
}
