@extends('layouts.admin', ['title' => __('ui.projects')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.content') }}</p><h1>{{ __('ui.projects') }}</h1><p class="muted">{{ __('ui.projects_from_database') }}</p></div><a class="btn" href="{{ route('admin.projects.create') }}">＋ {{ __('ui.add_project') }}</a></div>
<div class="admin-table-wrap"><table><thead><tr><th>{{ __('ui.project') }}</th><th>{{ __('ui.category') }}</th><th>{{ __('ui.links') }}</th><th>{{ __('ui.flags') }}</th><th>{{ __('ui.actions') }}</th></tr></thead><tbody>
@forelse($projects as $project)
    <tr>
        <td><span class="table-primary">{{ $project->title }}</span><span class="table-secondary">/{{ $project->slug }}</span></td>
        <td class="muted">{{ $project->category?->name ?: '—' }}</td>
        <td>@if($project->github_url)<a class="table-secondary" href="{{ $project->github_url }}" target="_blank" rel="noopener">{{ __('ui.github') }} ↗</a>@endif @if($project->live_demo_url)<a class="table-secondary" href="{{ $project->live_demo_url }}" target="_blank" rel="noopener">{{ __('ui.live_demo') }} ↗</a>@endif</td>
        <td><span class="status-badge {{ $project->published && $project->active ? '' : 'inactive' }}">{{ $project->published ? __('ui.published') : __('ui.draft') }}</span>@if($project->featured)<span class="table-secondary">★ {{ __('ui.featured') }}</span>@endif</td>
        <td><div class="action-row"><a class="btn small secondary" href="{{ route('admin.projects.edit', $project) }}">{{ __('ui.edit') }}</a><form class="inline" method="POST" action="{{ route('admin.projects.toggle', [$project, 'published']) }}">@csrf<button class="btn small" type="submit">{{ $project->published ? __('ui.unpublish') : __('ui.publish') }}</button></form><form class="inline" method="POST" action="{{ route('admin.projects.destroy', $project) }}">@csrf @method('DELETE')<button class="btn small danger" type="submit" onclick="return confirm('{{ __('ui.delete_confirm') }}')">{{ __('ui.delete') }}</button></form></div></td>
    </tr>
@empty
    <tr><td colspan="5" class="muted">{{ __('ui.no_records') }}</td></tr>
@endforelse
</tbody></table></div>{{ $projects->links('components.pagination') }}
@endsection
