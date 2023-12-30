<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Models\Book;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookService
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(): Collection
    {
        return $this->repository->all();
    }

    public function show(int $id): ?Book
    {
        return $this->repository->find($id, 'Codl');
    }

    public function store(array $data): ?Book
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->create($data);

            $ids = array_column($data['Autores'], 'id');
            $resource->authors()->attach($ids);

            $ids = array_column($data['Assuntos'], 'id');
            $resource->subjects()->attach($ids);

            DB::commit();

            return $resource;
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }

    public function update($id, $data): ?Book
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, 'Codl');

            $ids = array_column($data['Autores'], 'id');
            $resource->authors()->sync($ids);

            $ids = array_column($data['Assuntos'], 'id');
            $resource->subjects()->sync($ids);

            unset($data['Autores'], $data['Assuntos']);

            $this->repository->update($data, $id, 'Codl');
            
            DB::commit();

            return $resource;
        } catch (Exception) {
            DB::rollBack();
        }

        return null;
    }

    public function destroy(int $id): ?Book
    {
        DB::beginTransaction();

        try {
            $resource = $this->repository->find($id, 'Codl');

            if ($resource) {
                $resource->authors()->detach();
                $resource->subjects()->detach();

                $this->repository->delete($id, 'Codl');

                DB::commit();

                return $resource;
            }
        } catch (Exception) {
            DB::rollBack();
        }

        return null;

    }
}
