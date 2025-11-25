<?php

namespace App\Repositories;

use App\Models\Slide;

class SlideRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Slide $model) {}

    public function getActiveStatus($limit = 3)
    {
        return $this->model->where('status', 1)->take($limit)->get();
    }
}
