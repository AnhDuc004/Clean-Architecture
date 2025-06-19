<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Post;

interface PostRepositoryInterface
{
    public function create(Post $post): Post;

    public function update(Post $post): bool;

    public function findById(int $id): ?Post;

    public function delete(int $id): bool;

    public function getAll(?string $title = null): array;

    public function toggleLike(int $postId, int $userId): bool;
}
