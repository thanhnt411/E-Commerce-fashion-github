<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Contact $model) {}

    public function create($data)
    {
        return $this->model->create($data);
    }
}
