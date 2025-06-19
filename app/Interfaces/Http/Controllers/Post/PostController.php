<?php

namespace App\Interfaces\Http\Controllers\Post;

use App\Application\UseCases\Post\CreatePostUseCase;
use App\Application\UseCases\Post\DeletePostUseCase;
use App\Application\UseCases\Post\GetPostUseCase;
use App\Application\UseCases\Post\ListPostsUseCase;
use App\Application\UseCases\Post\SearchPostUseCase;
use App\Application\UseCases\Post\ToggleLikePostUseCase;
use App\Application\UseCases\Post\UpdatePostUseCase;
use App\Interfaces\Http\Requests\Post\CreatePostRequest;
use App\Interfaces\Http\Requests\Post\UpdatePostRequest;
use Illuminate\Http\Request;


class PostController
{
    public function __construct(private CreatePostUseCase $createPostUseCase) {}

    public function store(CreatePostRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = $this->createPostUseCase->execute(
            $request->title,
            $request->content,
            auth()->id(),
            $imagePath
        );

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
        ])->setStatusCode(201);
    }

    public function index(Request $request, ListPostsUseCase $listPostsUseCase)
    {
        $title = $request->query('title');
        $posts = $listPostsUseCase->execute($title);
        return response()->json($posts);
    }

    public function show(int $id, GetPostUseCase $showPostUseCase)
    {
        $post = $showPostUseCase->execute($id);
        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json($post);
    }

    public function destroy(int $id, DeletePostUseCase $deletePostUseCase)
    {
        $deleted = $deletePostUseCase->execute($id);
        if (!$deleted) {
            return response()->json(['message' => 'Post not found'], 404);
        }
        return response()->json(['message' => 'Post deleted successfully']);
    }

    public function update(int $id, UpdatePostRequest $request, UpdatePostUseCase $updatePostUseCase)
    {
        $data = $request->validated();

        $post = $updatePostUseCase->execute($id, $data['title'], $data['content']);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post);
    }

    public function toggleLike(int $id, ToggleLikePostUseCase $likePostUseCase)
    {
        $userId = auth()->id();
        $liked = $likePostUseCase->execute($id, $userId);
        return response()->json([
            'message' => $liked ? 'Post liked successfully' : 'Post unliked successfully',
            'liked' => $liked
        ]);
    }
}
