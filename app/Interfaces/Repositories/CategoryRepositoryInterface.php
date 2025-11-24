<?php

namespace App\Interfaces\Repositories;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Category;

    public function getLatesCategory(int $limit);

    public function getFirstCategory();
}
