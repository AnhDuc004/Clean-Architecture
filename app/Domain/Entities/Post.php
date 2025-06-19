<?php

namespace App\Domain\Entities;

// use JsonSerializable;

class Post 
{
    public function __construct(
        public ?int $id,
        public string $title,
        public string $content,
        public int $userId,
        public ?string $image = null,
        public int $likesCount = 0
    ) {}
   
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
