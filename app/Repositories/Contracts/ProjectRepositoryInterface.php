<?php

namespace App\Repositories\Contracts;

use App\Models\Project;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function findBySlugOrFail(string $slug): Project;
}
