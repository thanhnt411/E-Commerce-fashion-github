<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'locality',
        'city',
        'address',
        'state',
        'landmark',
        'zip',
        'user_id',
        'isdeafult',
        'country',
    ];
}
