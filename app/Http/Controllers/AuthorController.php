<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\DefaultCollection;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

class AuthorController extends Controller
{
    private AuthorService $service;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(AuthorResource::class, $this->service->index()));
    }

    public function show(int $id): JsonResponse
    {
        $resource = $this->service->show($id);

        return $this->success(new AuthorResource($resource));
    }

    public function store(StoreAuthorRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        return $this->created(new AuthorResource($resource));
    }

    public function update(UpdateAuthorRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->validated());

        return $this->noContent();
    }

    public function destroy(int $id): JsonResponse
    {
        $resource = $this->service->destroy($id);

        return $this->noContent();
    }
}
