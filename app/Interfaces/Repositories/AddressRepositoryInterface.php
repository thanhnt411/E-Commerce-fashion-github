<?php

namespace App\Interfaces\Repositories;

interface AddressRepositoryInterface
{
    public function getAddress($user_id);

    public function create($data);
}
