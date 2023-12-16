<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrUpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    private PostService $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PostResource::collection($this->service->getList());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateOrUpdatePostRequest $request): PostResource
    {
        return PostResource::make($this->service->create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOrUpdatePostRequest $request, Post $post): PostResource
    {
        return PostResource::make($this->service->update($post, $request->validated()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response()->noContent();
    }
}
