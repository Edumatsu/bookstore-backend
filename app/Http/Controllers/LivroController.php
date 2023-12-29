<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroRequest;
use App\Http\Requests\UpdateLivroRequest;
use App\Http\Resources\LivroResource;
use App\Http\Resources\DefaultCollection;
use App\Services\LivroService;
use Illuminate\Http\JsonResponse;

/**
 * @group Livros
 * APIs para gerenciar livros
 * @authenticated
 *
 * Class LivroController
 * @package App\Http\Controllers
 */
class LivroController extends Controller
{
    private $service;

    public function __construct(LivroService $service)
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
        return $this->success(new DefaultCollection(LivroResource::class, $this->service->index()));
    }

    /**
     * Detalhe de um livro
     *
     * @param Livro $livro
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

        return $this->success(new LivroResource($resource));
    }

    /**
     * Cria um novo livro
     *
     * @param LivroRequest $request
     * @return JsonResponse
     */
    public function store(LivroRequest $request): JsonResponse
    {
        $resource = $this->service->store($request->validated());

        if (!$resource) {
            return $this->error([
                "message" => "Erro na criação do livro"
            ]);
        }

        return $this->created(new LivroResource($resource));
    }

    /**
     * Atualiza um livro
     *
     * @param Livro $livro
     * @return JsonResponse
     */
    public function update(UpdateLivroRequest $request, int $id): JsonResponse
    {
        $livro->update($request->validated());
        $livro->autores()->sync($request->Autores);

        return $this->noContent();
    }

    /**
     * Exclui um livro
     *
     * @param Livro $livro
     * @return JsonResponse
     */
    public function destroy(Livro $livro): JsonResponse
    {
        $livro->autores()->detach();
        $livro->delete();

        return $this->noContent();
    }
}
