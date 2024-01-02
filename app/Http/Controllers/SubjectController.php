<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\DefaultCollection;
use App\Services\SubjectService;
use Illuminate\Http\JsonResponse;

class SubjectController extends Controller
{
    private SubjectService $service;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(SubjectResource::class, $this->service->index()));
    }

    public function show(int $id): JsonResponse
    {
        $resource = $this->service->show($id);

        return $this->success(new SubjectResource($resource));
    }

    public function store(StoreSubjectRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        return $this->created(new SubjectResource($resource));
    }

    public function update(UpdateSubjectRequest $request, int $id): JsonResponse
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
