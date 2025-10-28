<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Slide;
use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::where('status', 1)->get()->take(3);
        $categories = Category::orderBy('id', 'DESC')->get()->take(10);
        $sproducts = Product::whereNotNull('sale_price')->where('sale_price', '<>', '')->inRandomOrder()->get()->take(8);
        $fproducts = Product::where('featured', 1)->get()->take(8);
        return view('index', compact('slides', 'categories', 'sproducts', 'fproducts'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function store_contact(StoreContactRequest $request)
    {
        $data = $request->validated();
        $contacts = Contact::create($data);
        return redirect()->back()->with('success', 'Your message has been successfully!');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $results = Product::where('name', 'LIKE', "%{$query}%")->get()->take(8);
        return response()->json($results);
    }
}
