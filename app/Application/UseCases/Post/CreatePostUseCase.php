<?php 

namespace App\Application\UseCases\Post;

use App\Domain\Entities\Post;
use App\Domain\Repositories\PostRepositoryInterface;

class CreatePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(string $title, string $content, int $userId, ?string $image = null): Post
    {
        $post = new Post(
            id: null,
            title: $title,
            content: $content,
            userId: $userId,
            image: $image
        );

        return $this->postRepository->create($post);
    }
    
}