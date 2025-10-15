<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreBrandRequest;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function brands()
    {
        $brands = Brand::orderBy('id', 'DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand()
    {
        return view('admin.add-brand');
    }

    public function store_brand(StoreBrandRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('brands', $fileName);
        }
        /*$img = Image::read($file->getRealPath());
        $img->resize(800, null, function ($const) {
            $const->aspectRatio();
            $const->upsize();
        });
        $path = 'brands/' . $fileName;
        Storage::disk('public')->put($path, (string) $img->endcode());*/
        $data['image'] =  $path;
        $brands = Brand::create($data);
        return redirect()->route('admin.brands')->with('status', 'Brand created successfully!');
    }

    public function edit_brand($id)
    {
        $brands = Brand::findOrFail($id);
        return view('admin.edit-brand', compact('brands'));
    }

    public function update_brand(StoreBrandRequest $request, $id)
    {
        $brands = Brand::findOrFail($id);
        $data = $request->validated();
        if ($request->hasFile('image')) {
            Storage::delete('image');
            $file = $request->file('image');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $path = $file->storeAs('brands', $fileName);
        }
        $data['image'] =  $path;
        $brands->update($data);
        return redirect()->route('admin.brands')->with('status', 'Brand updated successfully!');
    }
    public function delete_brand($id)
    {
        $brands = Brand::findOrFail($id);
        if ($brands->image && Storage::exists($brands->image)) {
            Storage::delete('$brands->image');
        }
        $brands->delete();
        return back()->with('status', 'Brand deleted successfully!');
    }
}
