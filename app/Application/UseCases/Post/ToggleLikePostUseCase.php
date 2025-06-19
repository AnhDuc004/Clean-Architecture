<?php 

namespace App\Application\UseCases\Post;

use App\Domain\Repositories\PostRepositoryInterface;

class ToggleLikePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $postId, int $userId): bool
    {
        return $this->postRepository->toggleLike($postId, $userId);
    }
}