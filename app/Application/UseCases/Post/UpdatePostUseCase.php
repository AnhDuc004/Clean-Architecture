<?php

namespace App\Application\UseCases\Post;

use App\Domain\Repositories\PostRepositoryInterface;

class UpdatePostUseCase
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function execute(int $id, string $title, string $content): ?array
    {
        $post = $this->postRepository->findById($id);

        if (!$post) return null;

        $post->title = $title;
        $post->content = $content;

        $this->postRepository->update($post);

        return $post->toArray();
    }
}
