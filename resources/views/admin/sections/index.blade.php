@extends('layouts.admin', ['title' => __('ui.sections')])
@section('content')
<div class="toolbar"><div><p class="eyebrow">{{ __('ui.system') }}</p><h1>{{ __('ui.sections_title') }}</h1><p class="muted">{{ __('ui.manage_database_content') }}</p></div></div>
<div class="admin-grid">@foreach($sections as $section)
    <form class="admin-card form-grid" method="POST" action="{{ route('admin.sections.update', $section) }}">@csrf @method('PUT')
        <h2 class="full">{{ $section->key }}</h2><label>{{ __('ui.tag') }}<input name="tag" value="{{ $section->tag }}"></label><label>{{ __('ui.title') }}<input name="title" value="{{ $section->title }}" required></label><label class="full">{{ __('ui.description') }}<textarea name="description">{{ $section->description }}</textarea></label><label>{{ __('ui.sort_order') }}<input type="number" name="sort_order" value="{{ $section->sort_order }}" min="0"></label><div class="form-actions"><button class="btn" type="submit">{{ __('ui.save_section') }}</button></div>
    </form>
    <form method="POST" action="{{ route('admin.sections.toggle', $section) }}">@csrf<button class="btn secondary" type="submit">{{ $section->active ? __('ui.deactivate') : __('ui.activate') }} · {{ $section->key }}</button></form>
@endforeach</div>
@endsection
