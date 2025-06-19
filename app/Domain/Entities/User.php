<?php

namespace App\Domain\Entities;

class User
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
