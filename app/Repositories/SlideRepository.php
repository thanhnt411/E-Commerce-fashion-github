<?php

namespace App\Repositories;

use App\Interfaces\Repositories\SlideRepositoryInterface;
use App\Models\Slide;

class SlideRepository implements SlideRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Slide $model) {}

    public function getActiveStatus($limit = 3)
    {
        return $this->model->where('status', 1)->take($limit)->get();
    }

    public function getLatestId()
    {
        return $this->model->orderBy('id', 'DESC')->paginate(12);
    }

    public function create($data)
    {
        return $this->model->create($data);
    }

    public function  update($slide, $data)
    {
        return $slide->update($data);
    }

    public function delete($slide)
    {
        return $slide->delete();
    }
}
