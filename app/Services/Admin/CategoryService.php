<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Services\FileService;
use App\Interfaces\Services\Admin\CategoryServiceInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected FileService $fileService,
        protected CategoryRepositoryInterface $categoryRepo
    ) {
        //
    }

    public function getCategoryIdDESC()
    {
        return $this->categoryRepo->getIdDESC();
    }

    public function storeCategory(array $data, $imgFile)
    {
        if ($imgFile) {
            $data['image'] =  $this->fileService->upload($imgFile, 'categories');
        }
        return $this->categoryRepo->create($data);
    }

    public function updateCategory(Category $category, array $data, $imgFile)
    {
        if ($imgFile) {
            $oldImg = $category->image;
            $data['image'] = $this->fileService->upload($imgFile, 'categories');
        }
        $updateCategory =  $this->categoryRepo->update($category, $data);

        if ($oldImg) {
            $this->fileService->delete($oldImg);
        }
        return $updateCategory;
    }

    public function deleteCategory(Category $category)
    {
        $this->fileService->delete($category->image);
        return $this->categoryRepo->delete($category);
    }
}
