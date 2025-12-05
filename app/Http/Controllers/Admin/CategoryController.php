<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Interfaces\Services\Admin\CategoryServiceInterface;

class CategoryController extends Controller
{
    public function __construct(protected CategoryServiceInterface $categoryService) {}

    //START Categories
    public function index()
    {
        $categories = $this->categoryService->getCategoryIdDESC();
        return view('admin.categories', compact('categories'));
    }

    public function create()
    {
        return view('admin.add-categories');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->storeCategory(
            $request->validated(),
            $request->file('image')
        );
        return redirect()->route('admin.categories')->with('status', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.edit-categories', [
            'categories' => $category
        ]);
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        $this->categoryService->updateCategory(
            $category,
            $request->validated(),
            $request->file('image'),
        );
        return redirect()->route('admin.categories')->with('status', 'Categories updated successfully!');
    }

    public function delete(Category $category)
    {
        $this->authorize('delete', $category);
        $this->categoryService->deleteCategory($category);
        return back()->with('status', 'Categories deleted successfully!');
    }
    //END Categories
}
