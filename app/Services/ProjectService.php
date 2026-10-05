<?php

namespace App\Services;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectService
{
    public function __construct(
        private ProjectRepositoryInterface $projects,
        private FileUploadService $files,
    ) {}

    public function create(array $data, ?UploadedFile $image = null, ?UploadedFile $thumbnail = null): Project
    {
        return DB::transaction(function () use ($data, $image, $thumbnail): Project {
            $data = $this->prepareData($data);
            $data['image_path'] = $this->files->store($image, 'projects/images');
            $data['thumbnail_path'] = $this->files->store($thumbnail, 'projects/thumbnails');
            $technologyIds = $data['technology_ids'] ?? [];
            unset($data['technology_ids']);

            $project = $this->projects->create($data);
            $project->technologies()->sync($technologyIds);

            return $project->load(['category', 'technologies']);
        });
    }

    public function update(Project $project, array $data, ?UploadedFile $image = null, ?UploadedFile $thumbnail = null): Project
    {
        return DB::transaction(function () use ($project, $data, $image, $thumbnail): Project {
            $data = $this->prepareData($data, $project);
            $data['image_path'] = $this->files->replace($image, $project->image_path, 'projects/images');
            $data['thumbnail_path'] = $this->files->replace($thumbnail, $project->thumbnail_path, 'projects/thumbnails');
            $technologyIds = $data['technology_ids'] ?? [];
            unset($data['technology_ids']);

            $project = $this->projects->update($project, $data);
            $project->technologies()->sync($technologyIds);

            return $project->load(['category', 'technologies']);
        });
    }

    public function delete(Project $project): bool
    {
        return DB::transaction(function () use ($project): bool {
            $this->files->delete($project->image_path);
            $this->files->delete($project->thumbnail_path);

            return $this->projects->delete($project);
        });
    }

    public function toggle(Project $project, string $attribute): Project
    {
        abort_unless(in_array($attribute, ['active', 'published', 'featured'], true), 422);

        return $this->projects->update($project, [$attribute => ! $project->{$attribute}]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function prepareData(array $data, ?Project $project = null): array
    {
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['project_status'] = $data['project_status'] ?: 'completed';

        if (is_string($data['case_study'] ?? null)) {
            $data['case_study'] = json_decode($data['case_study'], true) ?: null;
        }

        if ($project && $project->slug === $data['slug']) {
            return $data;
        }

        return $data;
    }
}
