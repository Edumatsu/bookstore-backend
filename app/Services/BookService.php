<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class BookService
 *
 * @package App\Services
 */
class BookService
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * @return Collection
     */
    public function index(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @param  integer $id
     * @return Collection
     */
    public function show(int $id): ?Book
    {
        return $this->repository->find($id, "Codl");
    }

    /**
     * @param  array $data
     * @return Collection
     */
    public function store(array $data): ?Book
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->create($data);

            $ids = array_column($data['Autores'], 'id');
            $resource->authors()->attach($ids);

            DB::commit();

            return $resource;
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }

    /**
     * @param  int   $id
     * @param  array $data
     * @return Collection
     */
    public function update($id, $data): ?Book
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, "Codl");

            $ids = array_column($data['Autores'], 'id');
            $resource->authors()->sync($ids);

            unset($data['Autores']);

            $this->repository->update($data, $id, 'Codl');
            
            DB::commit();

            return $resource;
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }

    /**
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id): ?Book
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, "Codl");

            if ($resource) {
                $resource->authors()->detach(1);

                $this->repository->delete($id, "Codl");

                DB::commit();

                return $resource;
            }
        } catch (Exception) {
            DB::rollBack();
        }

        return null;

    }
}
