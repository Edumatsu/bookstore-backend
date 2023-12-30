<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\DefaultCollection;
use App\Services\SubjectService;
use Illuminate\Http\JsonResponse;

/**
 * Class SubjectController
 *
 * @package App\Http\Controllers
 */
class SubjectController extends Controller
{
    private $service;

    public function __construct(SubjectService $service)
    {
        $this->service = $service;
    }
    /**
     * Lista todos os assuntos
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(SubjectResource::class, $this->service->index()));
    }

    /**
     * Detalhe de um assunto
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $resource = $this->service->show($id);

        if (!$resource) {
            return $this->error(
                [
                    "message" => "Assunto não encontrado"
                ]
            );
        }

        return $this->success(new SubjectResource($resource));
    }

    /**
     * Cria um novo assunto
     *
     * @param  StoreSubjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreSubjectRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        if (!$resource) {
            return $this->error(
                [
                    "message" => "Erro na criação do Assunto"
                ]
            );
        }

        return $this->created(new SubjectResource($resource));
    }

    /**
     * Atualiza um assunto
     *
     * @param  int                  $id
     * @param  UpdateSubjectRequest $request
     * @return JsonResponse
     */
    public function update(UpdateSubjectRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->validated());

        if (!$resource) {
            return $this->error(
                [
                    "message" => "Erro ao alterar o Assunto"
                ]
            );
        }

        return $this->noContent();
    }

    /**
     * Exclui um assunto
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $resource = $this->service->destroy($id);

        if (!$resource) {
            return $this->error(
                [
                    "message" => "Erro ao excluir o Assunto"
                ]
            );
        }

        return $this->noContent();
    }
}
