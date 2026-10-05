<?php

namespace App\Repositories\Eloquent;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository extends EloquentRepository implements ProjectRepositoryInterface
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function findBySlugOrFail(string $slug): Project
    {
        return $this->model->newQuery()->with(['category', 'technologies'])->where('slug', $slug)->firstOrFail();
    }
}
