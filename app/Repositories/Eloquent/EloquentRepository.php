<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class EloquentRepository implements RepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function all(array $relations = []): Collection
    {
        return $this->model->newQuery()->with($relations)->orderBy('sort_order')->get();
    }

    public function paginate(int $perPage = 15, array $relations = []): LengthAwarePaginator
    {
        return $this->model->newQuery()->with($relations)->orderBy('sort_order')->paginate($perPage);
    }

    public function findOrFail(int|string $id, array $relations = []): Model
    {
        return $this->model->newQuery()->with($relations)->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->newQuery()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->fill($data);
        $model->save();

        return $model->refresh();
    }

    public function delete(Model $model): bool
    {
        return (bool) $model->delete();
    }
}
