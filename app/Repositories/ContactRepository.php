<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }
}
