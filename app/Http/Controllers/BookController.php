<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Http\Resources\DefaultCollection;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class BookController
 * @package App\Http\Controllers
 */
class BookController extends Controller
{
    private $service;

    public function __construct(BookService $service)
    {
        $this->service = $service;
    }
    /**
     * Lista todos os livros
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(BookResource::class, $this->service->index()));
    }

    /**
     * Detalhe de um livro
     *
     * @param Book $livro
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $resource = $this->service->show($id);

        if (!$resource) {
            return $this->error([
                "message" => "Livro não encontrado"
            ]);
        }

        return $this->success(new BookResource($resource));
    }

    /**
     * Cria um novo livro
     *
     * @param BookRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        if (!$resource) {
            return $this->error([
                "message" => "Erro na criação do livro"
            ]);
        }

        return $this->created(new BookResource($resource));
    }

    /**
     * Atualiza um livro
     *
     * @param Book $livro
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, int $id): JsonResponse
    {
        $resource = $this->service->update($id, $request->validated());

        if (!$resource) {
            return $this->error([
                "message" => "Erro ao alterar o Livro"
            ]);
        }

        return $this->noContent();
    }

    /**
     * Exclui um livro
     *
     * @param Book $livro
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $resource = $this->service->destroy($id);

        if (!$resource) {
            return $this->error([
                "message" => "Erro ao excluir o Livro"
            ]);
        }

        return $this->noContent();
    }
}
