<?php

namespace App\Repositories;

use App\Interfaces\Repositories\BrandRepositoryInterface;
use App\Models\Brand;
use Illuminate\Support\Collection;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Brand  $model) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Brand
    {
        return $this->model->find($id);
    }

    public function getFirstBrand()
    {
        return $this->model->orderBy('name', 'ASC')->get();
    }

    public function getIdDESC()
    {
        return $this->model->orderBy('id', 'DESC')->paginate(10);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function  update($brandId, $data)
    {
        return $this->model->find($brandId)->update($data);
    }
}
