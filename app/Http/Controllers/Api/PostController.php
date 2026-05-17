<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $queryParams = $request->validate([
            "search" => ["nullable", "string", "max:255"],
            "page" => ["integer", "min:1"],
            "perPage" => ["sometimes", "integer", "max:100"],
            "order" => ["string", Rule::in(["asc", "desc"])],
            "lang" => ["string", Rule::in(["pt", "en", "es"])]
        ]);

        $posts = Post::query()
            ->when($queryParams["search"], fn($query) => $query->whereFullText(['title, slug, excerpt, content, tags'], $queryParams['search']))
            ->when($queryParams["page"], fn($query) => $query->paginate($queryParams["perPage"] ?? 10, page: $queryParams["page"]))
            ->when($queryParams["order"], fn($query) => $query->orderBy('publish_date', $queryParams['order']))
            ->where("lang", $queryParams["lang"] ?? 'pt')
            ->where('publish_date < now()')
            ->get();

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
