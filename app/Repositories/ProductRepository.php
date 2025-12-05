<?php

namespace App\Repositories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use App\Interfaces\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Create a new class instance.
     */

    public function __construct(protected Product $model) {}

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Product
    {
        return $this->model->find($id);
    }

    public function getSaleProduct($limit = 8)
    {
        return $this->model->whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->take($limit)->get();
    }

    public function getFeatureProduct($limit = 8)
    {
        return $this->model->where('featured', 1)->take($limit)->get();
    }

    public function search($query, $limit = 8)
    {
        return $this->model->where('name', 'LIKE', "%{$query}%")->take($limit)->get();
    }

    public function filtersProducts($f_brands, $f_categories, $min_price, $max_price, $o_colum, $o_order, $size)
    {
        return $this->model->where(function ($query) use ($f_brands) {
            $query->whereIn('brand_id', explode(',', $f_brands))->orWhereRaw("'" . $f_brands . "'=''");
        })
            ->where(function ($query) use ($f_categories) {
                $query->whereIn('category_id', explode(',', $f_categories))->orWhereRaw("'" . $f_categories . "'=''");
            })
            ->where(function ($query) use ($min_price, $max_price) {
                $query->whereBetween('regular_price', [$min_price, $max_price])->orWhereBetween('sale_price', [$min_price, $max_price]);
            })
            ->orderBy($o_colum, $o_order)->paginate($size);
    }

    public function getProductSlug($product_slug)
    {
        return $this->model->where('slug', $product_slug)->firstOrFail();
    }

    public function getProductsNotEqualSlug($product_slug, $limit = 8)
    {
        return $this->model->where('slug', '<>', $product_slug)->take($limit)->get();
    }

    public function getLatestProduct()
    {
        return $this->model->orderBy('created_at', 'DESC')->paginate(10);
    }

    public function selectCategory()
    {
        return Category::select('id', 'name')->orderBy('name')->get();
    }

    public function selectBrand()
    {
        return Brand::select('id', 'name')->orderBy('name')->get();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function  update($product, $data)
    {
        return $product->update($data);
    }

    public function delete($product)
    {
        return $product->delete();
    }
}
