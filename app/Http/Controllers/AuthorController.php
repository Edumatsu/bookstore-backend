<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\DefaultCollection;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;

/**
 * Class AuthorController
 *
 * @package App\Http\Controllers
 */
class AuthorController extends Controller
{
    private $service;

    public function __construct(AuthorService $service)
    {
        $this->service = $service;
    }
    /**
     * Lista todos os autores
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(AuthorResource::class, $this->service->index()));
    }

    /**
     * Detalhe de um autor
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
                    "message" => "Autor não encontrado"
                ]
            );
        }

        return $this->success(new AuthorResource($resource));
    }

    /**
     * Cria um novo autor
     *
     * @param  StoreAuthorRequest $request
     * @return JsonResponse
     */
    public function store(StoreAuthorRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        if (!$resource) {
            return $this->error(
                [
                    "message" => "Erro na criação do autor"
                ]
            );
        }

        return $this->created(new AuthorResource($resource));
    }

    /**
     * Atualiza um autor
     *
     * @param  int                 $id
     * @param  UpdateAuthorRequest $request
     * @return JsonResponse
     */
    public function update(UpdateAuthorRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->validated());

        if (!$resource) {
            return $this->error(
                [
                    "message" => "Erro ao alterar o Autor"
                ]
            );
        }

        return $this->noContent();
    }

    /**
     * Exclui um autor
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
                    "message" => "Erro ao excluir o Autor"
                ]
            );
        }

        return $this->noContent();
    }
}
