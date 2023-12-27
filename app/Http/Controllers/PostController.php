<?php

namespace App\Http\Controllers;

use App\Actions\UpdateModelLikeAction;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\MediaService;
use App\Services\PostService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $postService,
        private readonly MediaService $mediaService,
    ) {}

    public function index(): JsonResource
    {
        return PostResource::collection($this->postService->getList());
    }

    public function store(StorePostRequest $request): JsonResource
    {
        return PostResource::make($this->postService->store($request->validated()));
    }

    public function show(Post $post): JsonResource
    {
        return PostResource::make($post->load(['user', 'media'])->loadCount(['likes'])->append(['is_liked']));
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResource
    {
        $this->authorize('update', $post);

        return PostResource::make($this->postService->update($post, $request->validated()));
    }

    public function destroy(Post $post): Response
    {
        $this->authorize('destroy', $post);

        $post->delete();

        return response()->noContent();
    }

    public function updateLike(UpdateModelLikeAction $action, Post $post): JsonResponse
    {
        return response()->json(['likes_count' => $action($post)]);
    }

    public function storeMedia(StoreMediaRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        return MediaResource::make($this->mediaService->store($post, $request->validated()));
    }
}
