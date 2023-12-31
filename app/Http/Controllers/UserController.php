<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Requests\Media\StoreMediaRequest;
use App\Http\Resources\MediaResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\MediaService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct(
        private readonly MediaService $mediaService,
    ) {}

    public function getMe(): JsonResource
    {
        return UserResource::make(Auth::user()->load('media'));
    }

    public function index(): JsonResource
    {
        return UserResource::collection(User::paginate());
    }

    public function show(User $user): JsonResource
    {
        return UserResource::make($user->load(['posts', 'media']));
    }

    public function storeMedia(StoreMediaRequest $request)
    {
        return MediaResource::make($this->mediaService->store(auth()->user(), $request->validated()));
    }

    public function export()
    {
        return Excel::download(new UsersExport(), 'users.xlsx');
    }
}
