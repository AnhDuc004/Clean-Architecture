<?php

namespace App\Application\UseCases\Post;

use App\Domain\Entities\Post;
use App\Domain\Repositories\PostRepositoryInterface;

class GetPostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $id): ?Post
    {
        return $this->postRepository->findById($id);
    }
}
