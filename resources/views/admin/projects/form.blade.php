@extends('layouts.admin', ['title' => ($project->exists ? __('ui.edit') : __('ui.create')).' '.__('ui.project')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.content') }}</p><h1>{{ $project->exists ? __('ui.edit') : __('ui.create') }} {{ __('ui.project') }}</h1></div><a class="btn secondary" href="{{ route('admin.projects.index') }}">← {{ __('ui.back') }}</a></div>
<form class="admin-card form-grid" method="POST" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
@csrf @if($project->exists) @method('PUT') @endif
<label>{{ __('ui.title') }}<input name="title" value="{{ old('title', $project->title) }}" required></label>
<label>{{ __('ui.slug') }}<input name="slug" value="{{ old('slug', $project->slug) }}" placeholder="generated-from-title"></label>
<label>{{ __('ui.category') }}<select name="category_id"><option value="">—</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(old('category_id', $project->category_id) == $category->id)>{{ $category->name }}</option>@endforeach</select></label>
<label>{{ __('ui.project_status') }}<input name="project_status" value="{{ old('project_status', $project->project_status ?: 'completed') }}" required></label>
<label class="full">{{ __('ui.short_description') }}<input name="short_description" value="{{ old('short_description', $project->short_description) }}" required></label>
<label class="full">{{ __('ui.full_description') }}<textarea name="full_description">{{ old('full_description', $project->full_description) }}</textarea></label>
<label>{{ __('ui.badge') }}<input name="badge" value="{{ old('badge', $project->badge) }}"></label>
<label>{{ __('ui.client_company') }}<input name="client_company" value="{{ old('client_company', $project->client_company) }}"></label>
<label>{{ __('ui.github_url') }}<input type="url" name="github_url" value="{{ old('github_url', $project->github_url) }}"></label>
<label>{{ __('ui.live_demo_url') }}<input type="url" name="live_demo_url" value="{{ old('live_demo_url', $project->live_demo_url) }}"></label>
<label>{{ __('ui.start_date') }}<input type="date" name="start_date" value="{{ old('start_date', $project->start_date?->format('Y-m-d')) }}"></label>
<label>{{ __('ui.completion_date') }}<input type="date" name="completion_date" value="{{ old('completion_date', $project->completion_date?->format('Y-m-d')) }}"></label>
<label>{{ __('ui.sort_order') }}<input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" required></label>
<label class="full">{{ __('ui.case_study_json') }}<textarea name="case_study">{{ old('case_study', $project->case_study ? json_encode($project->case_study, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '') }}</textarea></label>
<label class="full">{{ __('ui.technology_ids') }}<select name="technology_ids[]" multiple size="8">@foreach($technologies as $technology)<option value="{{ $technology->id }}" @selected(in_array($technology->id, old('technology_ids', $project->technologies->pluck('id')->all()), true))>{{ $technology->name }}</option>@endforeach</select></label>
<label>{{ __('ui.project_image') }}<input type="file" name="image" accept="image/*"></label><label>{{ __('ui.thumbnail') }}<input type="file" name="thumbnail" accept="image/*"></label>
<label><span>{{ __('ui.featured') }}</span><input type="hidden" name="featured" value="0"><input type="checkbox" name="featured" value="1" @checked(old('featured', $project->featured))></label>
<label><span>{{ __('ui.published') }}</span><input type="hidden" name="published" value="0"><input type="checkbox" name="published" value="1" @checked(old('published', $project->exists ? $project->published : true))></label>
<label><span>{{ __('ui.active') }}</span><input type="hidden" name="active" value="0"><input type="checkbox" name="active" value="1" @checked(old('active', $project->exists ? $project->active : true))></label>
<div class="form-actions"><a class="btn secondary" href="{{ route('admin.projects.index') }}">{{ __('ui.back') }}</a><button class="btn" type="submit">{{ __('ui.save_project') }}</button></div>
</form>
@endsection
