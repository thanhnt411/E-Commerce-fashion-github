<?php

namespace App\Services\Admin;

use App\Models\Slide;
use App\Services\FileService;
use App\Interfaces\Services\Admin\SlideServiceInterface;
use App\Interfaces\Repositories\SlideRepositoryInterface;

class SlideService implements SlideServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected SlideRepositoryInterface $slideRepo,
        protected FileService $fileService
    ) {}

    public function getLatestId()
    {
        return $this->slideRepo->getLatestId();
    }

    public function store(array $data, $imgFile)
    {
        if ($imgFile) {
            $data['image'] =  $this->fileService->upload($imgFile, 'slides');
        }
        return $this->slideRepo->create($data);
    }

    public function update(Slide $slide, array $data, $imgFile)
    {
        if ($imgFile) {
            $oldImg = $slide->image;
            $data['image'] = $this->fileService->upload($imgFile, 'slides');
        }
        $updateSlide =  $this->slideRepo->update($slide, $data);

        if ($oldImg) {
            $this->fileService->delete($oldImg);
        }
        return $updateSlide;
    }

    public function delete(Slide $slide)
    {
        $this->fileService->delete($slide->image);
        return $this->slideRepo->delete($slide);
    }
}
