<?php

namespace App\Services;

use App\Repositories\Contracts\ContentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class ContentService
{
    public function __construct(private ContentRepositoryInterface $repository) {}

    public function index(string $search = ''): mixed
    {
        return $this->repository->paginate(15);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        return $this->repository->update($model, $data);
    }

    public function delete(Model $model): bool
    {
        return $this->repository->delete($model);
    }
}
