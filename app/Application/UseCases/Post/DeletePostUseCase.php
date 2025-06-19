<?php 

namespace App\Application\UseCases\Post;

use App\Domain\Repositories\PostRepositoryInterface;

class DeletePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $id): bool
    {
        return $this->postRepository->delete($id);
    }
}