<?php

namespace App\Interfaces\Repositories;

use App\Models\Brand;
use Illuminate\Support\Collection;

interface BrandRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Brand;

    public function getFirstBrand();

    public function getIdDESC();

    public function create($data);

    public function update($brand, $data);

    public function delete($brand);
}
