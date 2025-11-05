<?php

namespace App\Repositories;

use App\Models\Slide;

class SlideRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct(Slide $model)
    {
        $this->model = $model;
    }

    public function getActiveStatus($limit = 3)
    {
        return $this->model->where('status', 1)->take($limit)->get();
    }
}
