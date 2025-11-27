<?php

namespace App\Repositories;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
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
        return Address::where('user_id', $user_id)->where('isdefault', 1)->first();
    }
}
