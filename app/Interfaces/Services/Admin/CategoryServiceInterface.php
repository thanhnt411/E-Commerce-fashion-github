<?php

namespace App\Interfaces\Services\Admin;

use App\Models\Category;

interface CategoryServiceInterface
{
    public function getCategoryIdDESC();

    public function storeCategory(array $data, $imgFile);

    public function updateCategory(Category $category,  array $data, $imgFile);

    public function deleteCategory(Category $category);
}
