<?php

namespace App\DTOs;

readonly class CartData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $name,
        public string $phone,
        public string $locality,
        public string $city,
        public string $address,
        public string $state,
        public string $landmark,
        public string $zip,
    ) {}
}
