@extends('layouts.admin', ['title' => __('ui.resource_'.$resource)])
@section('content')
@php($resourceLabel = __('ui.resource_'.$resource))
<div class="toolbar">
    <div><p class="eyebrow">{{ __('ui.content') }}</p><h1>{{ $resourceLabel }}</h1><p class="muted">{{ __('ui.manage_database_content') }}</p></div>
    <a class="btn" href="{{ route('admin.'.$resource.'.create') }}">＋ {{ __('ui.add_new') }}</a>
</div>
<div class="admin-table-wrap">
    <table>
        <thead><tr><th>ID</th><th>{{ __('ui.primary_content') }}</th><th>{{ __('ui.order') }}</th><th>{{ __('ui.status') }}</th><th>{{ __('ui.actions') }}</th></tr></thead>
        <tbody>
        @forelse ($items as $item)
            <tr>
                <td class="muted">#{{ $item->id }}</td>
                <td><span class="table-primary">{{ $item->name ?? $item->title ?? $item->position ?? $item->institution ?? $item->company }}</span></td>
                <td class="muted">{{ $item->sort_order }}</td>
                <td><span class="status-badge {{ $item->active ? '' : 'inactive' }}">{{ $item->active ? __('ui.active') : __('ui.inactive') }}</span></td>
                <td><div class="action-row"><a class="btn small secondary" href="{{ route('admin.'.$resource.'.edit', $item->id) }}">{{ __('ui.edit') }}</a><form class="inline" method="POST" action="{{ route('admin.'.$resource.'.destroy', $item->id) }}">@csrf @method('DELETE')<button class="btn small danger" type="submit" onclick="return confirm('{{ __('ui.delete_confirm') }}')">{{ __('ui.delete') }}</button></form></div></td>
            </tr>
        @empty
            <tr><td colspan="5" class="muted">{{ __('ui.no_records') }}</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
{{ $items->links('components.pagination') }}
@endsection
