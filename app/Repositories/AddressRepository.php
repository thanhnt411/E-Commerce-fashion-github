<?php

namespace App\Repositories;

use App\Models\Address;
use App\Interfaces\Repositories\AddressRepositoryInterface;

class AddressRepository implements AddressRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Address $model)
    {
        //
    }

    public function getAddress($user_id)
    {
        return $this->model->where('user_id', $user_id)->where('isdefault', 1)->first();
    }

    public function create($data)
    {
        return $this->model->create($data);
    }
}
