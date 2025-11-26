<?php

namespace App\DTOs;

readonly class WishlistData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $id,
        public string $name,
        public int $qty,
        public string $price
    ) {
        //
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'qty' => $this->qty,
            'price' => $this->price
        ];
    }
}
