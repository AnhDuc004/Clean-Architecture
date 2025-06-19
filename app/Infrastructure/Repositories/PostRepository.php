<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\PostRepositoryInterface;
use App\Domain\Entities\Post as DomainPost;
use App\Models\Post as EloquentPost;
use App\Models\PostLike;

class PostRepository implements PostRepositoryInterface
{
    public function create(DomainPost $post): DomainPost
    {
        $eloquentPost = EloquentPost::create([
            'title' => $post->title,
            'content' => $post->content,
            'user_id' => $post->userId,
            'image' => $post->image
        ]);
        return new DomainPost($eloquentPost->id, $eloquentPost->title, $eloquentPost->content, $eloquentPost->user_id, $eloquentPost->image);
    }

    public function update(DomainPost $post): bool
    {
        $eloquentPost = EloquentPost::find($post->id);

        if (!$eloquentPost) {
            return false;
        }

        $eloquentPost->update([
            'title' => $post->title,
            'content' => $post->content,
        ]);

        return true;
    }

    public function findById(int $id): ?DomainPost
    {
        $eloquentPost = EloquentPost::find($id);
        if (!$eloquentPost) {
            return null;
        }

        return new DomainPost($eloquentPost->id, $eloquentPost->title, $eloquentPost->content, $eloquentPost->user_id, $eloquentPost->image);
    }

    public function delete(int $id): bool
    {
        $eloquentPost = EloquentPost::find($id);
        if (!$eloquentPost) {
            return false;
        }

        return $eloquentPost->delete();
    }

    public function getAll(?string $title = null): array
    {
        $query = EloquentPost::withCount('likes');

        if ($title) {
            $query->where('title', 'like', '%' . $title . '%');
        }
        
        return $query->get()->map(function ($model) {
            return new DomainPost(
                $model->id,
                $model->title,
                $model->content,
                $model->user_id,
                $model->image,
                $model->likes_count
            );
        })->toArray();
    }

    public function toggleLike(int $postId, int $userId): bool
    {
        $like = PostLike::where('post_id', $postId)->where('user_id', $userId)->first();

        if ($like) {
            $like->delete();
            return false; // Unliked
        }

        PostLike::create([
            'post_id' => $postId,
            'user_id' => $userId
        ]);

        return true; // Liked
    }
}
