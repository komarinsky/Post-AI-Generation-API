<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'is_liked' => $this->whenAppended('is_liked'),
            'likes_count' => $this->whenCounted('likes'),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
