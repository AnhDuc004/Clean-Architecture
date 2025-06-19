<?php 

namespace App\Application\UseCases\Post;

use App\Domain\Repositories\PostRepositoryInterface;
use App\Domain\Entities\Post as DomainPost;

class EditPostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(DomainPost $post): bool
    {
        return $this->postRepository->update($post);
    }
}