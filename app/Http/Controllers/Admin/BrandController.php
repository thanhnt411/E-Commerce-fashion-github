<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Interfaces\Services\Admin\BrandServiceInterface;

class BrandController extends Controller
{
    public function __construct(protected BrandServiceInterface $brandService) {}

    public function index()
    {
        $brands = $this->brandService->getBrandIdDESC();
        return view('admin.brands', compact('brands'));
    }

    public function create()
    {
        return view('admin.add-brand');
    }

    public function store(StoreBrandRequest $request)
    {
        $this->brandService->storeBrand(
            $request->validated(),
            $request->file('image')
        );
        return redirect()->route('admin.brands')->with('status', 'Brand created successfully!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.edit-brand', [
            'brands' => $brand
        ]);
    }

    public function update(StoreBrandRequest $request, Brand $brand)
    {
        $this->authorize('update', $brand);
        $this->brandService->updateBrand(
            $brand,
            $request->validated(),
            $request->file('image'),
        );
        return redirect()->route('admin.brands')->with('status', 'Brand updated successfully!');
    }

    public function delete(Brand $brand)
    {
        $this->authorize('delete', $brand);
        $this->brandService->deleteBrand($brand);
        return back()->with('status', 'Brand deleted successfully!');
    }
}
