<?php

namespace App\Interfaces\Services\Admin;

use App\Models\Slide;

interface SlideServiceInterface
{
    public function getLatestId();

    public function store(array $data, $imgFile);

    public function update(Slide $Slide,  array $data, $imgFile);

    public function delete(Slide $Slide);
}
