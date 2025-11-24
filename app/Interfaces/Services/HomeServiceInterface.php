<?php

namespace App\Interfaces\Services;

interface HomeServiceInterface
{
    public function getHomeData();

    public function saveContact(array $data);

    public function searchProduct($query);
}
