<?php

namespace App\DTOs;

readonly class ContactData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone = null,
        public string $comment
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'comment' => $this->comment
        ];
    }
}
