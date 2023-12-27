<?php

namespace App\Http\Controllers;

use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Requests\Media\UpdateMediaRequest;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Services\MediaService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class MediaController extends Controller
{
    public function __construct(
        private MediaService $service,
    ) {}

    public function index(): JsonResource
    {
        return MediaResource::collection($this->service->getList());
    }

    public function show(Media $media): JsonResource
    {
        return MediaResource::make($media);
    }

    public function update(Media $media, UpdateMediaRequest $request): JsonResource
    {
        $this->authorize('update', $media);

        return MediaResource::make($this->service->update($media, $request->validated()));
    }

    public function destroy(Media $media): Response
    {
        $this->authorize('destroy', $media);

        $this->service->destroy($media);

        return response()->noContent();
    }
}
