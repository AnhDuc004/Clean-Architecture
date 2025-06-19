<?php 

namespace App\Application\UseCases\Post;

use App\Domain\Repositories\PostRepositoryInterface;

class ListPostsUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(?string $query = null): array
    {
        return $this->postRepository->getAll($query);
    }
}