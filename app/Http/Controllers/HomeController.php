<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Interfaces\Services\HomeServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(protected HomeServiceInterface $homeService) {}

    public function index()
    {
        $data = $this->homeService->getHomeData();
        return view('index', $data);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function store_contact(StoreContactRequest $request)
    {
        $this->homeService->saveContact($request->validated());
        return redirect()->back()->with('success', 'Your message has been successfully!');
    }

    public function search(Request $request)
    {
        $results = $this->homeService->searchProduct($request->input('query'));
        return response()->json($results);
    }
}
