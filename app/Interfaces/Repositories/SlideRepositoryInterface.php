<?php

namespace App\Interfaces\Repositories;

interface SlideRepositoryInterface
{
    public function getActiveStatus($limit);

    public function getLatestId();

    public function create($data);

    public function update($brand, $data);

    public function delete($brand);
}
