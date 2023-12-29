<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroRequest;
use App\Http\Requests\UpdateLivroRequest;
use App\Http\Resources\LivroResource;
use App\Http\Resources\DefaultCollection;
use App\Models\Livro;
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
    /**
     * Lista todos os livros
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->success(new DefaultCollection(LivroResource::class, Livro::all()));
    }

    /**
     * Detalhe de um livro
     *
     * @param Livro $livro
     * @return JsonResponse
     */
    public function show(Livro $livro): JsonResponse
    {
        return $this->success(new LivroResource($livro));
    }

    /**
     * Cria um novo livro
     *
     * @param LivroRequest $request
     * @return JsonResponse
     */
    public function store(LivroRequest $request): JsonResponse
    {
        $resource = Livro::query()->create($request->validated());
        $resource->autores()->attach($request->Autores);

        return $this->created(new LivroResource($resource));
    }

    /**
     * Atualiza um livro
     *
     * @param Livro $livro
     * @return JsonResponse
     */
    public function update(UpdateLivroRequest $request, Livro $livro): JsonResponse
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
