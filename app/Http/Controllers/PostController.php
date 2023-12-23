<?php

namespace App\Http\Controllers;

use App\Actions\UpdateModelLikeAction;
use App\Http\Requests\CreatePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class PostController extends Controller
{
    public function __construct(
        private readonly PostService $service,
    ) {}

    public function index(): JsonResource
    {
        return PostResource::collection($this->service->getList());
    }

    public function store(CreatePostRequest $request): JsonResource
    {
        return PostResource::make($this->service->create($request->validated()));
    }

    public function show(Post $post): JsonResource
    {
        return PostResource::make($post->load(['user'])->loadCount(['likes'])->append(['is_liked']));
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResource
    {
        $this->authorize('update', $post);

        return PostResource::make($this->service->update($post, $request->validated()));
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
}
