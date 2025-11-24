<?php

namespace App\Http\Controllers;

use App\Interfaces\Services\ShopServiceInterface;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function __construct(protected ShopServiceInterface $shopService) {}

    public function index(Request $request)
    {
        $filters = [
            'order' => $request->query('order') ? $request->query('order') : -1,
            'f_brands' => $request->query('brands'),
            'f_categories' => $request->query('categories'),
            'min_price' => $request->query('min') ? $request->query('min') : 1,
            'max_price' => $request->query('max') ? $request->query('max') : 2000,
            'size' => $request->query('size') ?  $request->query('size') : 12,
        ];

        $data = $this->shopService->getShopData();
        $products = $this->shopService->getFiltersProducts($filters);
        return view('shop', array_merge($data, [
            'products' => $products,
            'filters' => $filters,
        ]));
    }

    public function products_detail($product_slug)
    {
        $product = $this->shopService->getProductSlug($product_slug);
        $rproducts = $this->shopService->getProductsNotEqualSlug($product_slug);
        return view('details', compact('product', 'rproducts'));
    }
}
