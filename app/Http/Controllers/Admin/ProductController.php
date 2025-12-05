<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Interfaces\Services\Admin\ProductServiceInterface;

class ProductController extends Controller
{
    public function __construct(protected ProductServiceInterface $productService) {}

    public function index()
    {
        $products = $this->productService->getLatestProduct();
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        $categories = $this->productService->selectCategory();
        $brands = $this->productService->selectBrand();
        return view('admin.add-products', [
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        $galleryFiles = $request->file('images');
        if ($galleryFiles && !is_array($galleryFiles)) {
            $galleryFiles = [$galleryFiles];
        }

        $this->productService->storeProduct(
            $request->validated(),
            $request->file('image'),
            $galleryFiles
        );
        return redirect()->route('admin.products')->with('status', 'Products created successfully!');
    }

    public function edit(Product $product)
    {
        $categories = $this->productService->selectCategory();
        $brands = $this->productService->selectBrand();
        return view('admin.edit-products', [
            'products' => $product,
            'categories' => $categories,
            'brands' => $brands
        ]);
    }

    public function update(StoreProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);
        $this->productService->updateProduct(
            $product,
            $request->validated(),
            $request->file('image'),
            $request->file('images')
        );
        return redirect()->route('admin.products')->with('status', 'Products updated successfully!');
    }

    public function delete(Product $product)
    {
        $this->authorize('delete', $product);
        $this->productService->deleteProduct($product);
        return back()->with('status', 'Products deleted successfully!');
    }
}
