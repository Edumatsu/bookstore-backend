<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\DefaultCollection;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    private BookService $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(BookResource::class, $this->service->index()));
    }

    public function show(int $id): JsonResponse
    {
        $resource = $this->service->show($id);

        return $this->success(new BookResource($resource));
    }

    public function store(StoreBookRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        return $this->created(new BookResource($resource));
    }

    public function update(UpdateBookRequest $request, int $id): JsonResponse
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
