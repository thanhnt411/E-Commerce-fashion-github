<?php

namespace App\Interfaces\Services;

use App\DTOs\ContactData;

interface HomeServiceInterface
{
    public function getHomeData();

    public function saveContact(ContactData $data);

    public function searchProduct($query);
}
