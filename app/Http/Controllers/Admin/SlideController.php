<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slide;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlideRequest;
use App\Interfaces\Services\Admin\SlideServiceInterface;

class SlideController extends Controller
{
    public function __construct(protected SlideServiceInterface $slideService) {}

    public function index()
    {
        $slides = $this->slideService->getLatestId();
        return view('admin.slides', compact('slides'));
    }

    public function create()
    {
        return view('admin.add-slides');
    }

    public function store(StoreSlideRequest $request)
    {
        $this->slideService->store(
            $request->validated(),
            $request->file('image')
        );
        return redirect()->route('admin.slides')->with('status', 'Slide created successfully!');
    }

    public function edit(Slide $slide)
    {
        return view('admin.edit-slides', [
            'slides' => $slide
        ]);
    }

    public function update(StoreSlideRequest $request, Slide $slide)
    {
        $this->authorize('update', $slide);
        $this->slideService->update(
            $slide,
            $request->validated(),
            $request->file('image'),
        );
        return redirect()->route('admin.slides')->with('status', 'Slides updated successfully!');
    }

    public function delete(Slide $slide)
    {
        $this->authorize('delete', $slide);
        $this->slideService->delete($slide);
        return back()->with('status', 'Slides deleted successfully!');
    }
}
