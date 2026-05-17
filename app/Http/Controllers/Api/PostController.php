<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PostIndexRequest $request)
    {
        $queryParams = $request->validated();

        $query = Post::query()
            ->when(
                $queryParams['search'] ?? null,
                fn($query, $search) => $query->whereFullText(['title', 'slug', 'excerpt', 'content'], $search)
            )
            ->when(
                $queryParams['order'] ?? null,
                fn($query, $order) => $query->orderBy('publish_date', $order)
            )
            ->where('lang', $queryParams['lang'] ?? 'pt')
            ->where('publish_date', '<=', now());

        $posts = $query->paginate(
            $queryParams['perPage'] ?? 10,
            page: $queryParams['page'] ?? 1
        );

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $post = Post::create($request->validated());
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post removido com sucesso'], 200);
    }
}
